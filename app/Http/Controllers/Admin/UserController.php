<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * get user list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $return = array();

        $req = $request->only('phone', 'nickname', 'pageNum', 'pageSize');

        $pageSize = $req['pageSize'] ?? 10;
        $pageNum = $req['pageNum'] ?? 1;
        $offset = ($pageNum - 1) * $pageSize;

        $userInstance = User::where('is_del', '0')->where(function($query) use($req){
            /** filter by params */
            if ($phone = array_val('phone', $req)) {
                $query->whereRaw("locate('{$phone}', `phone`) > 0");
            }
            if ($nickname = array_val('nickname', $req)) {
                $query->whereRaw("locate('{$nickname}', `nickname`) > 0");
            }
        });

        $count = $userInstance->count();
        $users = $userInstance->offset($offset)->limit($pageSize)->orderBy('id', 'DESC')->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['list'] = $users;
        $return['result']['page'] = [
            'pageNum'=>$pageNum,
            'pageSize'=>$pageSize,
            'total'=>$count
        ];

        return response()->json($return);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * store a user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $return = [];

        $req = $request->only('phone', 'nickname', 'tags', 'head_image_url');

        $phone = $req['phone'] ?? '';
        $nickname = $req['nickname'] ?? '';
        $headImageUrl = $req['head_image_url'] ?? '';
        $tags = $req['tags'] ?? [];

        if (!$phone) {
            $return['code'] = 'E1001';
            $return['message'] = '電話番号を入力してください。';
            return response()->json($return);
        }
        if (!$nickname) {
            $return['code'] = 'E1002';
            $return['message'] = '氏名を入力してください。';
            return response()->json($return);
        }

        $exists = User::where('phone', $phone)->count();

        if ($exists) {
            $return['code'] = 'E1003';
            $return['message'] = 'この電話番号はすでに存在します。';
            return response()->json($return);
        }

        $user = User::create([
            'code'=>strtoupper(uniqid()),
            'phone'=>$phone,
            'password'=>bcrypt('123456'),
            'head_image_url'=>$headImageUrl,
            'nickname'=>$nickname,
            'tags'=>json_encode($tags, JSON_UNESCAPED_UNICODE),
        ]);

        if (!$user) {
            $return['code'] = 'E1004';
            $return['message'] = 'データの追加に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * update a user
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $return = [];

        $req = $request->only('phone', 'nickname', 'tags', 'head_image_url');

        $phone = $req['phone'] ?? '';
        $nickname = $req['nickname'] ?? '';
        $headImageUrl = $req['head_image_url'] ?? '';
        $tags = $req['tags'] ?? [];

        if (!$phone) {
            $return['code'] = 'E1005';
            $return['message'] = '電話番号を入力してください。';
            return response()->json($return);
        }
        if (!$nickname) {
            $return['code'] = 'E1006';
            $return['message'] = '氏名を入力してください。';
            return response()->json($return);
        }

        $exists = User::where('id', '!=', $id)->where('phone', $phone)->count();

        if ($exists) {
            $return['code'] = 'E1007';
            $return['message'] = 'この電話番号はすでに存在します。';
            return response()->json($return);
        }

        $res = User::where('id', $id)->update([
            'phone'=>$phone,
            'head_image_url'=>$headImageUrl,
            'nickname'=>$nickname,
            'tags'=>json_encode($tags, JSON_UNESCAPED_UNICODE),
        ]);

        if ($res === false) {
            $return['code'] = 'E1008';
            $return['message'] = 'データの更新に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * delete a user
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $return = array();

        $res = User::where('id', $id)->update(['is_del'=>'1']);

        if ($res === false) {
            $return['code'] = 'E1009';
            $return['message'] = 'データの削除に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * get all users
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = User::select(['id', 'phone', 'nickname', 'head_image_url'])->orderBy('id', 'ASC')->get();

        return response()->json($return);
    }
}
