<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * user login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::find(1);
        $tokenData = $this->createToken($user);

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['token'] = $tokenData;
        $return['result']['user'] = $user;

        return response()->json($return);
    }

    /**
     * refresh token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $return = array();
        $req = $request->only('refresh_token');

        $refreshToken = $req['refresh_token'] ?? '';

        if (!$refreshToken) {
            $return['code'] = 'E4004';
            $return['message'] = 'Invalid refresh token';
            return response()->json($return);
        }

        $refreshData = DB::table('refresh_tokens')->where('refresh_token', $refreshToken)->first();
        if (!$refreshData || strtotime($refreshData->created_at) + $refreshData->expires_in < time()) {
            $return['code'] = 'E4004';
            $return['message'] = 'Invalid refresh token';
            return response()->json($return);
        }

        $fileName = $refreshToken . '.lock';
        $filePath = public_path('/lock/' . $fileName);
        if (!file_exists($filePath)) {
            file_put_contents($filePath, time());
        }

        $fp = fopen($filePath, 'r');
        flock($fp, LOCK_EX);

        $user = User::find($refreshData->type_id);
        $cache = Cache::get($refreshToken);
        if ($cache) {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
            $return['result']['token'] = json_decode($cache, true);
            $return['result']['user'] = $user;
            return response()->json($return);
        }


        $tokenData = $this->createToken($user);

        Cache::add($refreshToken, $tokenData, 2);

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['token'] = $tokenData;
        $return['result']['user'] = $user;

        flock($fp, LOCK_UN);
        fclose($fp);

        return response()->json($return);
    }

    /**
     * create token
     * @param User $user
     * @return array
     */
    private function createToken(User $user): array
    {
        $expireAt = Carbon::now()->addHours(env('USER_ACCESS_TOKEN_EXPIRE'));
        $token = $user->createToken($user->code, ['*'], $expireAt)->plainTextToken;

        $refreshToken = Str::random(64);
        DB::table('refresh_tokens')->insert([
            'type'=>'users',
            'type_id'=>$user->id,
            'refresh_token'=>$refreshToken,
            'created_at'=>date('Y-m-d H:i:s'),
            'expires_in'=>env('REFRESH_TOKEN_EXPIRE')
        ]);

        return [
            'token_type' => 'Bearer',
            'access_token' => $token,
            'refresh_token' => $refreshToken,
        ];
    }
}
