<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CupController extends Controller
{
    /**
     * cup game list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $return = array();

        $req = $request->only('name', 'pageNum', 'pageSize');

        $pageSize = $req['pageSize'] ?? 10;
        $pageNum = $req['pageNum'] ?? 1;
        $offset = ($pageNum - 1) * $pageSize;

        $cupInstance = Cup::where('is_del', '0')->where(function($query) use($req){
            /** filter by params */
            if ($name = array_val('name', $req)) {
                $query->whereRaw("locate('{$name}', `name`) > 0");
            }
        });

        $count = $cupInstance->count();
        $cups = $cupInstance->offset($offset)->limit($pageSize)->orderBy('id', 'DESC')->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['list'] = $cups;
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
     * store cup game
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $return = [];

        $req = $request->only('name', 'user_number', 'start_date', 'end_date', 'memo');

        $name = $req['name'] ?? '';
        $userNumber = $req['user_number'] ?? '';
        $startDate = $req['start_date'] ?? '';
        $endDate = $req['end_date'] ?? '';

        if (!$name) {
            $return['code'] = 'E4001';
            $return['message'] = 'カップ戦名を入力してください。';
            return response()->json($return);
        }
        if (!$userNumber) {
            $return['code'] = 'E4002';
            $return['message'] = '参加人数を入力してください。';
            return response()->json($return);
        }
        if (!$startDate) {
            $return['code'] = 'E4003';
            $return['message'] = '開始日を選択してください。';
            return response()->json($return);
        }
        if (!$endDate) {
            $return['code'] = 'E4004';
            $return['message'] = '終了日を選択してください。';
            return response()->json($return);
        }

        $cup = Cup::create([
            'name'=>$name,
            'user_number'=>$userNumber,
            'start_date'=>$startDate,
            'end_date'=>$endDate,
            'memo'=>$req['memo'] ?? '',
        ]);

        if (!$cup) {
            $return['code'] = 'E4005';
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
     * update cup game
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $return = [];

        $req = $request->only('name', 'user_number', 'start_date', 'end_date', 'memo');

        $name = $req['name'] ?? '';
        $userNumber = $req['user_number'] ?? '';
        $startDate = $req['start_date'] ?? '';
        $endDate = $req['end_date'] ?? '';

        if (!$name) {
            $return['code'] = 'E4006';
            $return['message'] = 'カップ戦名を入力してください。';
            return response()->json($return);
        }
        if (!$userNumber) {
            $return['code'] = 'E4007';
            $return['message'] = '参加人数を入力してください。';
            return response()->json($return);
        }
        if (!$startDate) {
            $return['code'] = 'E4008';
            $return['message'] = '開始日を選択してください。';
            return response()->json($return);
        }
        if (!$endDate) {
            $return['code'] = 'E4009';
            $return['message'] = '終了日を選択してください。';
            return response()->json($return);
        }

        $res = Cup::where('id', $id)->update([
            'name'=>$name,
            'user_number'=>$userNumber,
            'start_date'=>$startDate,
            'end_date'=>$endDate,
            'memo'=>$req['memo'] ?? '',
        ]);

        if ($res === false) {
            $return['code'] = 'E4010';
            $return['message'] = 'データの更新に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * delete cup game
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $return = array();

        $res = Cup::where('id', $id)->update(['is_del'=>'1']);

        if ($res === false) {
            $return['code'] = 'E4011';
            $return['message'] = 'データの削除に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * get cup users
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cupUsers(string $id)
    {
        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = DB::table('cup_users')
            ->select(['users.id', 'users.phone', 'users.nickname', 'users.head_image_url'])
            ->leftJoin('users', 'cup_users.user_id', '=', 'users.id')
            ->where(['cup_id'=>$id, 'status'=>1])
            ->orderBy('users.id', 'ASC')
            ->get();

        return response()->json($return);
    }

    /**
     * set game users and create game
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCupData(Request $request, string $id)
    {
        $return = array();

        $req = $request->only('users', 'create_game');
        $users = $req['users'] ?? [];

        $exists = DB::table('cup_games')->where('cup_id', $id)->count();
        if ($exists > 0) {
            $return['code'] = 'E4012';
            $return['message'] = 'カップ戦はすでに生成されているため、参加ユーザーを設定できません。';
            return response()->json($return);
        }

        $delRes = DB::table('cup_users')->where('cup_id', $id)->delete();
        if ($delRes === false) {
            $return['code'] = 'E4013';
            $return['message'] = '参加ユーザーの設定に失敗しました。しばらくしてからもう一度お試しください。';
            return response()->json($return);
        }

        if (!$users) {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
            return response()->json($return);
        }

        $insertData = array();
        foreach ($users as $key=>$user) {
            $insertData[$key]['cup_id'] = $id;
            $insertData[$key]['user_id'] = $user['id'];
            $insertData[$key]['status'] = '1';
            $insertData[$key]['serial_number'] = $key + 1;
        }
        $insertRes = DB::table('cup_users')->insert($insertData);

        if (!$insertRes) {
            $return['code'] = 'E4014';
            $return['message'] = '参加ユーザーの設定に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';

            $createGame = $req['create_game'] ?? false;
            if ($createGame) {
                $this->createGame($id, $insertData);
            }
        }

        return response()->json($return);
    }

    /**
     * get latest cup game data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cupGames(Request $request)
    {
        $return = array();

        $req = $request->only('name');

        $cupName = $req['name'] ?? '';

        $cup = null;
        if ($cupName) {
            $cup = Cup::where(['name'=>$cupName, 'is_del'=>'0'])->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }
        if (!$cup) {
            $cup = Cup::where('is_del', '0')->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }

        if (!$cup) {
            $return['code'] = 'E4020';
            $return['message'] = 'データがありません。';
            return response()->json($return);
        }

        $cupGames = DB::table('cup_games')
            ->select([
                'cup_games.*',
                'user_home.nickname AS nickname_home',
                'user_home.head_image_url AS head_image_home',
                'user_away.nickname AS nickname_away',
                'user_away.head_image_url AS head_image_away',
            ])
            ->leftJoin('users AS user_home', function($join){
                $join->on('cup_games.user_id_home', '=', 'user_home.id');
            })
            ->leftJoin('users AS user_away', function($join){
                $join->on('cup_games.user_id_away', '=', 'user_away.id');
            })
            ->where('cup_id', $cup->id)
            ->orderBy('round', 'ASC')
            ->orderBy('game_time', 'ASC')
            ->orderBy('cup_games.id', 'ASC')
            ->get();

        $cupGamesGroupByRoundObject = array();
        foreach ($cupGames as $cupGame) {
            $cupGamesGroupByRoundObject[$cupGame->round][] = $cupGame;
        }

        $cupGamesGroupByRoundArray = array();
        $index = 0;
        foreach ($cupGamesGroupByRoundObject as $round=>$games) {
            $cupGamesGroupByRoundArray[$index]['round'] = $round;
            $cupGamesGroupByRoundArray[$index]['games'] = $games;
            $index++;
        }

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = $cupGamesGroupByRoundArray;

        return response()->json($return);
    }

    /**
     * update cup game data
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCupGames(Request $request, string $id)
    {
        $return = array();

        $req = $request->only('home_goal', 'away_goal', 'home_goal_penalty', 'away_goal_penalty', 'game_time', 'status');

        $updateData = array();
        if (array_key_exists('home_goal', $req)) {
            $updateData['home_goal'] = $req['home_goal'];
        }
        if (array_key_exists('away_goal', $req)) {
            $updateData['away_goal'] = $req['away_goal'];
        }
        if (array_key_exists('home_goal_penalty', $req)) {
            $updateData['home_goal_penalty'] = $req['home_goal_penalty'];
        }
        if (array_key_exists('away_goal_penalty', $req)) {
            $updateData['away_goal_penalty'] = $req['away_goal_penalty'];
        }
        if (array_key_exists('game_time', $req)) {
            $updateData['game_time'] = $req['game_time'];
        }
        if (array_key_exists('status', $req)) {
            $updateData['status'] = $req['status'];
        }

        $res = DB::table('cup_games')->where('id', $id)->update($updateData);

        if ($res === false) {
            $return['code'] = 'E4015';
            $return['message'] = 'データの更新に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';

            if (array_key_exists('status', $updateData) && $updateData['status']) {
                $this->calcGameData($id);
            }
        }

        return response()->json($return);
    }

    /**
     * get cup ranking data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse\
     */
    public function cupRanking(Request $request)
    {
        $return = array();

        $req = $request->only('name');

        $cupName = $req['name'] ?? '';

        $cup = null;
        if ($cupName) {
            $cup = Cup::where(['name'=>$cupName, 'is_del'=>'0'])->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }
        if (!$cup) {
            $cup = Cup::where('is_del', '0')->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }

        if (!$cup) {
            $return['code'] = 'E4020';
            $return['message'] = 'カップ戦のデータがありません。';
            return response()->json($return);
        }

        $cupRanking = DB::table('cup_users')
            ->select(['cup_users.*', 'users.nickname', 'users.head_image_url'])
            ->leftJoin('users', 'cup_users.user_id', '=', 'users.id')
            ->where(['cup_id'=>$cup->id, 'status'=>1])
            ->orderBy('round', 'DESC')
            ->orderBy('serial_number', 'ASC')
            ->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = $cupRanking;

        return response()->json($return);
    }

    /**
     * create cup games
     * @param $cupId
     * @param $users
     * @param $round
     * @return void
     */
    private function createGame($cupId, $users, $round=1)
    {
        if (count($users) < 2) {
            return;
        }

        $gameData = array();
        $index = 0;
        for ($i = 0; $i < count($users); $i+=2) {
            if (!array_key_exists($i+1, $users)) {
                /** last team is advanced directly when team number is Odd */
                DB::table('cup_users')->where(['cup_id'=>$cupId, 'user_id'=>$users[$i]])->update(['round'=>$round]);
                break;
            }

            $gameData[$index]['cup_id'] = $cupId;
            $gameData[$index]['user_id_home'] = $users[$i]['user_id'];
            $gameData[$index]['user_id_away'] = $users[$i+1]['user_id'];
            $gameData[$index]['serial_number_home'] = $users[$i]['serial_number'];
            $gameData[$index]['serial_number_away'] = $users[$i+1]['serial_number'];
            $gameData[$index]['round'] = $round;
            $gameData[$index]['game_time'] = date('Y-m-d') . ' 00:00:00';

            $index++;
        }

        DB::table('cup_games')->insert($gameData);
    }

    /**
     * calculate game data
     * @param $cupGameId
     * @return void
     */
    private function calcGameData($cupGameId): void
    {
        $cupGame = DB::table('cup_games')->where('id', $cupGameId)->first();

        /** home team game data */
        $userHomeGame = DB::table('cup_games')
            ->where(['cup_id'=>$cupGame->cup_id, 'status'=>1])
            ->where(function($query) use($cupGame) {
                $query->orWhere('user_id_home', $cupGame->user_id_home);
                $query->orWhere('user_id_away', $cupGame->user_id_home);
            })->get();

        /** away team game data */
        $userAwayGame = DB::table('cup_games')
            ->where(['cup_id'=>$cupGame->cup_id, 'status'=>1])
            ->where(function($query) use($cupGame) {
                $query->orWhere('user_id_home', $cupGame->user_id_away);
                $query->orWhere('user_id_away', $cupGame->user_id_away);
            })->get();

        /** home team total data */
        $userHomeData = [
            'goal'=>0,
            'conceded'=>0,
            'round'=>$cupGame->round,
        ];

        /** away team total data */
        $userAwayData = [
            'goal'=>0,
            'conceded'=>0,
            'round'=>$cupGame->round,
        ];

        /** home team calculate */
        foreach ($userHomeGame as $game) {
            if ($cupGame->user_id_home == $game->user_id_home) {
                /** home game */
                $userHomeData['goal'] += $game->home_goal;
                $userHomeData['conceded'] += $game->away_goal;
            } else {
                /** away game */
                $userHomeData['goal'] += $game->away_goal;
                $userHomeData['conceded'] += $game->home_goal;
            }
        }

        /** away team calculate */
        foreach ($userAwayGame as $game) {
            if ($cupGame->user_id_away == $game->user_id_home) {
                /** home game */
                $userAwayData['goal'] += $game->home_goal;
                $userAwayData['conceded'] += $game->away_goal;
            } else {
                /** away game */
                $userAwayData['goal'] += $game->away_goal;
                $userAwayData['conceded'] += $game->home_goal;
            }
        }

        DB::table('cup_users')->where(['cup_id'=>$cupGame->cup_id, 'user_id'=>$cupGame->user_id_home])->update($userHomeData);
        DB::table('cup_users')->where(['cup_id'=>$cupGame->cup_id, 'user_id'=>$cupGame->user_id_away])->update($userAwayData);

        /** create next round games after this round */
        $hasNextRound = DB::table('cup_games')->where(['cup_id'=>$cupGame->cup_id, 'round'=>$cupGame->round+1])->count();
        if ($hasNextRound) {
            return;
        }

        $cupGames = DB::table('cup_games')->where(['cup_id'=>$cupGame->cup_id, 'round'=>$cupGame->round])->get();

        $notFinished = false;
        $userIds = array();//win users
        $userAllIds = array();//all users
        foreach ($cupGames as $game) {
            if (!$game->status) {
                $notFinished = true;
                break;
            }

            if ($game->home_goal + $game->home_goal_penalty > $game->away_goal + $game->away_goal_penalty) {
                $userIds[] = $game->user_id_home;
            } else {
                $userIds[] = $game->user_id_away;
            }

            $userAllIds[] = $game->user_id_home;
            $userAllIds[] = $game->user_id_away;
        }

        if ($notFinished) return;

        /** the users have game in this round (array) */
        $usersHasGame = DB::table('cup_users')
            ->where(['cup_id'=>$cupGame->cup_id, 'round'=>$cupGame->round])
            ->whereIn('user_id', $userIds)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $usersHasGameArray = $usersHasGame->map(function($item) {
            return (array) $item;
        })->toArray();

        /** the users don't have game in this round (when user number is odd) */
        $usersNoGame = DB::table('cup_users')
            ->where(['cup_id'=>$cupGame->cup_id, 'round'=>$cupGame->round])
            ->whereNotIn('user_id', $userAllIds)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $usersNoGameArray = $usersNoGame->map(function($item) {
            return (array) $item;
        })->toArray();

        $this->createGame($cupGame->cup_id, array_merge($usersHasGameArray, $usersNoGameArray), $cupGame->round+1);
    }
}
