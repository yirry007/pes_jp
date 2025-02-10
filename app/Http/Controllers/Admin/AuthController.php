<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * admin login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $return = array();

        $req = $request->only('username', 'password');
        $username = $req['username'] ?? '';
        $password = $req['password'] ?? '';

        if (!$username || !$password) {
            $return['code'] = 'E4001';
            $return['message'] = 'ユーザー名とパスワードを入力してください。';
            return response()->json($return);
        }

        $admin = Admin::where('username', $username)->first();

        if (!$admin || !Hash::check($password, $admin->password)) {
            $return['code'] = 'E4002';
            $return['message'] = 'ユーザー名またはパスワードが間違っています。';
            return response()->json($return);
        }

        $tokenData = $this->createToken($admin);
        $tokenData['uname'] = $admin->username;

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = $tokenData;

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

        $admin = Admin::find($refreshData->type_id);
        $cache = Cache::get($refreshToken);
        if ($cache) {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
            $return['result'] = json_decode($cache, true);
            return response()->json($return);
        }

        $tokenData = $this->createToken($admin);
        $tokenData['uname'] = $admin->username;

        Cache::add($refreshToken, $tokenData, 2);

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = $tokenData;

        flock($fp, LOCK_UN);
        fclose($fp);

        return response()->json($return);
    }

    /**
     * logout
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->user()->currentAccessToken()->delete();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';

        return response()->json($return);
    }

    /**
     * create token
     * @param Admin $admin
     * @return array
     */
    private function createToken(Admin $admin): array
    {
        $expireAt = Carbon::now()->addHours(env('ADMIN_ACCESS_TOKEN_EXPIRE'));
        $token = $admin->createToken($admin->username, ['*'], $expireAt)->plainTextToken;

        $refreshToken = Str::random(64);
        DB::table('refresh_tokens')->insert([
            'type'=>'admins',
            'type_id'=>$admin->id,
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
