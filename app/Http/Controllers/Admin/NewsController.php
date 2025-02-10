<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * get news list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $return = array();

        $req = $request->only('title', 'pageNum', 'pageSize');

        $pageSize = $req['pageSize'] ?? 10;
        $pageNum = $req['pageNum'] ?? 1;
        $offset = ($pageNum - 1) * $pageSize;

        $newsInstance = News::where(function($query) use($req){
            /** filter by params */
            if ($title = array_val('title', $req)) {
                $query->whereRaw("locate('{$title}', `title`) > 0");
            }
        });

        $count = $newsInstance->count();
        $news = $newsInstance->offset($offset)->limit($pageSize)->orderBy('sort', 'DESC')->orderBy('id', 'DESC')->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['list'] = $news;
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
     * store news
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $return = [];

        $req = $request->only('is_banner', 'title', 'subject', 'image', 'url', 'sort', 'is_use');

        $title = $req['title'] ?? '';

        if (!$title) {
            $return['code'] = 'E5001';
            $return['message'] = 'タイトルを入力してください。';
            return response()->json($return);
        }

        $news = News::create([
            'is_banner'=>$req['is_banner'] ?? '0',
            'title'=>$title,
            'subject'=>$req['subject'] ?? '',
            'image'=>$req['image'] ?? '',
            'url'=>$req['url'] ?? '',
            'sort'=>$req['sort'] ?? '9',
            'is_use'=>$req['is_use'] ?? '1',
            'create_at'=>date('Y-m-d H:i:s'),
        ]);

        if (!$news) {
            $return['code'] = 'E5002';
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
     * update news
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $return = [];

        $req = $request->only('is_banner', 'title', 'subject', 'image', 'url', 'sort', 'is_use');

        $title = $req['title'] ?? '';

        if (!$title) {
            $return['code'] = 'E5003';
            $return['message'] = 'タイトルを入力してください。';
            return response()->json($return);
        }

        $res = News::where('id', $id)->update([
            'is_banner'=>$req['is_banner'] ?? '0',
            'title'=>$title,
            'subject'=>$req['subject'] ?? '',
            'image'=>$req['image'] ?? '',
            'url'=>$req['url'] ?? '',
            'sort'=>$req['sort'] ?? '9',
            'is_use'=>$req['is_use'] ?? '1',
        ]);

        if ($res === false) {
            $return['code'] = 'E5004';
            $return['message'] = 'データの更新に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * delete news
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $return = array();

        $res = News::destroy($id);

        if ($res === false) {
            $return['code'] = 'E5005';
            $return['message'] = 'データの削除に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }
}
