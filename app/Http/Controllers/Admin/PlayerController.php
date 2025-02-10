<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    /**
     * get player list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $return = array();

        $req = $request->only('name', 'nation', 'position', 'rating_start', 'rating_end', 'pageNum', 'pageSize');

        $pageSize = $req['pageSize'] ?? 10;
        $pageNum = $req['pageNum'] ?? 1;
        $offset = ($pageNum - 1) * $pageSize;

        $playerInstance = Player::where(function($query) use($req){
            /** filter by params */
            if (array_key_exists('name', $req) && $req['name']) {
                $query->where(function($q) use($req) {
                    $name = trim($req['name']);
                    $q->orWhereRaw("locate('{$name}', `name`) > 0");
                    $q->orWhereRaw("locate('{$name}', `name_en`) > 0");
                    $q->orWhereRaw("locate('{$name}', `full_name`) > 0");
                });
            }
            if (array_key_exists('nation', $req) && $req['nation']) {
                $query->where(function($q) use($req) {
                    $nation = trim($req['nation']);
                    $q->orWhere('nation', $nation);
                    $q->orWhere('nation_abbr', $nation);
                });
            }
            if ($ratingStart = array_val('rating_start', $req)) {
                $query->where('rating', '>=', $ratingStart);
            }
            if ($ratingEnd = array_val('rating_end', $req)) {
                $query->where('rating', '<=', $ratingEnd);
            }
        });

        $count = $playerInstance->count();
        $player = $playerInstance
            ->select(DB::raw('
                *
                ,CONCAT("'._url_('/').'/", headimg) AS image_url
                ,CONCAT(CONCAT("'._url_('/images/nations/flag_').'", nation_abbr), ".png") AS nation_image
            '))
            ->offset($offset)->limit($pageSize)
            ->orderBy('id', 'ASC')
            ->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['list'] = $player;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
