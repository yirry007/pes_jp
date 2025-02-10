<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
    /**
     * league game list
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

        $leagueInstance = League::where('is_del', '0')->where(function($query) use($req){
            /** filter by params */
            if ($name = array_val('name', $req)) {
                $query->whereRaw("locate('{$name}', `name`) > 0");
            }
        });

        $count = $leagueInstance->count();
        $leagues = $leagueInstance->offset($offset)->limit($pageSize)->orderBy('id', 'DESC')->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['list'] = $leagues;
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
     * store league game
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $return = [];

        $req = $request->only('name', 'user_number', 'game_mode', 'start_date', 'end_date', 'memo');

        $name = $req['name'] ?? '';
        $userNumber = $req['user_number'] ?? '';
        $startDate = $req['start_date'] ?? '';
        $endDate = $req['end_date'] ?? '';

        if (!$name) {
            $return['code'] = 'E3001';
            $return['message'] = 'リーグ名を入力してください。';
            return response()->json($return);
        }
        if (!$userNumber) {
            $return['code'] = 'E3002';
            $return['message'] = '参加人数を入力してください。';
            return response()->json($return);
        }
        if (!$startDate) {
            $return['code'] = 'E3003';
            $return['message'] = '開始日を選択してください。';
            return response()->json($return);
        }
        if (!$endDate) {
            $return['code'] = 'E3004';
            $return['message'] = '終了日を選択してください。';
            return response()->json($return);
        }

        $league = League::create([
            'name'=>$name,
            'user_number'=>$userNumber,
            'game_mode'=>$req['game_mode'] ?? '1',
            'start_date'=>$startDate,
            'end_date'=>$endDate,
            'memo'=>$req['memo'] ?? '',
        ]);

        if (!$league) {
            $return['code'] = 'E3005';
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
     * update league game
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $return = [];

        $req = $request->only('name', 'user_number', 'game_mode', 'start_date', 'end_date', 'memo');

        $name = $req['name'] ?? '';
        $userNumber = $req['user_number'] ?? '';
        $startDate = $req['start_date'] ?? '';
        $endDate = $req['end_date'] ?? '';

        if (!$name) {
            $return['code'] = 'E3006';
            $return['message'] = 'リーグ名を入力してください。';
            return response()->json($return);
        }
        if (!$userNumber) {
            $return['code'] = 'E3007';
            $return['message'] = '参加人数を入力してください。';
            return response()->json($return);
        }
        if (!$startDate) {
            $return['code'] = 'E3008';
            $return['message'] = '開始日を選択してください。';
            return response()->json($return);
        }
        if (!$endDate) {
            $return['code'] = 'E3009';
            $return['message'] = '終了日を選択してください。';
            return response()->json($return);
        }

        $res = League::where('id', $id)->update([
            'name'=>$name,
            'user_number'=>$userNumber,
            'game_mode'=>$req['game_mode'] ?? '1',
            'start_date'=>$startDate,
            'end_date'=>$endDate,
            'memo'=>$req['memo'] ?? '',
        ]);

        if ($res === false) {
            $return['code'] = 'E3010';
            $return['message'] = 'データの更新に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * delete league game
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $return = array();

        $res = League::where('id', $id)->update(['is_del'=>'1']);

        if ($res === false) {
            $return['code'] = 'E3011';
            $return['message'] = 'データの削除に失敗しました。しばらくしてからもう一度お試しください。';
        } else {
            $return['code'] = '';
            $return['message'] = 'SUCCESS';
        }

        return response()->json($return);
    }

    /**
     * get league users
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function leagueUsers(string $id)
    {
        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = DB::table('league_users')
            ->select(['users.id', 'users.phone', 'users.nickname', 'users.head_image_url'])
            ->leftJoin('users', 'league_users.user_id', '=', 'users.id')
            ->where(['league_id'=>$id, 'status'=>1])
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
    public function updateLeagueData(Request $request, string $id)
    {
        $return = array();

        $req = $request->only('users', 'create_game');
        $users = $req['users'] ?? [];

        $exists = DB::table('league_games')->where('league_id', $id)->count();
        if ($exists > 0) {
            $return['code'] = 'E3012';
            $return['message'] = 'リーグ日程はすでに生成されているため、参加ユーザーを設定できません。';
            return response()->json($return);
        }

        $delRes = DB::table('league_users')->where('league_id', $id)->delete();
        if ($delRes === false) {
            $return['code'] = 'E3013';
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
            $insertData[$key]['league_id'] = $id;
            $insertData[$key]['user_id'] = $user['id'];
            $insertData[$key]['status'] = '1';
        }
        $insertRes = DB::table('league_users')->insert($insertData);

        if (!$insertRes) {
            $return['code'] = 'E3014';
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
     * get latest league game data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leagueGames(Request $request)
    {
        $return = array();

        $req = $request->only('name');

        $leagueName = $req['name'] ?? '';

        $league = null;
        if ($leagueName) {
            $league = League::where(['name'=>$leagueName, 'is_del'=>'0'])->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }
        if (!$league) {
            $league = League::where('is_del', '0')->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }

        if (!$league) {
            $return['code'] = 'E3020';
            $return['message'] = 'データがありません。';
            return response()->json($return);
        }

        $leagueGames = DB::table('league_games')
            ->select([
                'league_games.*',
                'user_home.nickname AS nickname_home',
                'user_home.head_image_url AS head_image_home',
                'user_away.nickname AS nickname_away',
                'user_away.head_image_url AS head_image_away',
            ])
            ->leftJoin('users AS user_home', function($join){
                $join->on('league_games.user_id_home', '=', 'user_home.id');
            })
            ->leftJoin('users AS user_away', function($join){
                $join->on('league_games.user_id_away', '=', 'user_away.id');
            })
            ->where('league_id', $league->id)
            ->orderBy('game_time', 'ASC')
            ->orderBy('league_games.id', 'ASC')
            ->get();

        $leagueGamesGroupByDateObject = array();
        foreach ($leagueGames as $leagueGame) {
            $date = explode(' ', $leagueGame->game_time)[0];

            $leagueGamesGroupByDateObject[$date][] = $leagueGame;
        }

        $leagueGamesGroupByDateArray = array();
        $index = 0;
        foreach ($leagueGamesGroupByDateObject as $date=>$games) {
            $leagueGamesGroupByDateArray[$index]['date'] = $date;
            $leagueGamesGroupByDateArray[$index]['games'] = $games;
            $index++;
        }

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = $leagueGamesGroupByDateArray;

        return response()->json($return);
    }

    /**
     * update league game data
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLeagueGames(Request $request, string $id)
    {
        $return = array();

        $req = $request->only('home_goal', 'away_goal', 'game_time', 'status');

        $updateData = array();
        if (array_key_exists('home_goal', $req)) {
            $updateData['home_goal'] = $req['home_goal'];
        }
        if (array_key_exists('away_goal', $req)) {
            $updateData['away_goal'] = $req['away_goal'];
        }
        if (array_key_exists('game_time', $req)) {
            $updateData['game_time'] = $req['game_time'];
        }
        if (array_key_exists('status', $req)) {
            $updateData['status'] = $req['status'];
        }

        $res = DB::table('league_games')->where('id', $id)->update($updateData);

        if ($res === false) {
            $return['code'] = 'E3015';
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
     * get league ranking data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leagueRanking(Request $request)
    {
        $return = array();

        $req = $request->only('name');

        $leagueName = $req['name'] ?? '';

        $league = null;
        if ($leagueName) {
            $league = League::where(['name'=>$leagueName, 'is_del'=>'0'])->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }
        if (!$league) {
            $league = League::where('is_del', '0')->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->first();
        }

        if (!$league) {
            $return['code'] = 'E3020';
            $return['message'] = 'データがありません。';
            return response()->json($return);
        }

        $leagueRanking = DB::table('league_users')
            ->select(DB::raw('league_users.*, users.nickname, users.head_image_url, (league_users.goal - league_users.conceded) AS difference'))
            ->leftJoin('users', 'league_users.user_id', '=', 'users.id')
            ->where(['league_id'=>$league->id, 'status'=>1])
            ->orderBy('score', 'DESC')
            ->orderBy('difference', 'DESC')
            ->orderBy('goal', 'DESC')
            ->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = $leagueRanking;

        return response()->json($return);
    }

    /**
     * create league games
     * @param $leagueId
     * @param $users
     * @return void
     */
    private function createGame($leagueId, $users)
    {
        $users1 = $users;
        $users2 = $users;
        $league = League::find($leagueId);

        $gameData = array();
        $index = 0;
        foreach ($users1 as $key1=>$user1) {
            foreach ($users2 as $key2=>$user2) {
                if ($user1['user_id'] == $user2['user_id']) {
                    if ($league->game_mode == 1) { //单场设置
                        unset($users2[$key2]);
                    }
                    continue;
                }

                $gameData[$index]['league_id'] = $leagueId;
                $gameData[$index]['user_id_home'] = $user1['user_id'];
                $gameData[$index]['user_id_away'] = $user2['user_id'];
                $gameData[$index]['game_time'] = date('Y-m-d') . ' 00:00:00';

                $index++;
            }
        }

        DB::table('league_games')->insert($gameData);
    }

    /**
     * calculate game data
     * @param $leagueGameId
     * @return void
     */
    private function calcGameData($leagueGameId): void
    {
        $leagueGame = DB::table('league_games')->where('id', $leagueGameId)->first();

        /** home team game data */
        $userHomeGame = DB::table('league_games')
            ->where(['league_id'=>$leagueGame->league_id, 'status'=>1])
            ->where(function($query) use($leagueGame) {
                $query->orWhere('user_id_home', $leagueGame->user_id_home);
                $query->orWhere('user_id_away', $leagueGame->user_id_home);
            })->get();

        /** away team game data */
        $userAwayGame = DB::table('league_games')
            ->where(['league_id'=>$leagueGame->league_id, 'status'=>1])
            ->where(function($query) use($leagueGame) {
                $query->orWhere('user_id_home', $leagueGame->user_id_away);
                $query->orWhere('user_id_away', $leagueGame->user_id_away);
            })->get();

        /** home team total data */
        $userHomeData = [
            'games'=>count($userHomeGame),
            'win'=>0,
            'draw'=>0,
            'lose'=>0,
            'goal'=>0,
            'conceded'=>0,
            'score'=>0,
        ];

        /** away team total data */
        $userAwayData = [
            'games'=>count($userAwayGame),
            'win'=>0,
            'draw'=>0,
            'lose'=>0,
            'goal'=>0,
            'conceded'=>0,
            'score'=>0,
        ];

        $winPoint = 3;//win point
        $drawPoint = 1;//draw point

        /** home team calculate */
        foreach ($userHomeGame as $game) {
            if ($leagueGame->user_id_home == $game->user_id_home) {
                /** home game */
                if ($game->home_goal > $game->away_goal) {
                    $userHomeData['win']++;
                    $userHomeData['score'] += $winPoint;
                } elseif ($game->home_goal < $game->away_goal) {
                    $userHomeData['lose']++;
                } else {
                    $userHomeData['draw']++;
                    $userHomeData['score'] += $drawPoint;
                }

                $userHomeData['goal'] += $game->home_goal;
                $userHomeData['conceded'] += $game->away_goal;
            } else {
                /** away game */
                if ($game->home_goal < $game->away_goal) {
                    $userHomeData['win']++;
                    $userHomeData['score'] += $winPoint;
                } elseif ($game->home_goal > $game->away_goal) {
                    $userHomeData['lose']++;
                } else {
                    $userHomeData['draw']++;
                    $userHomeData['score'] += $drawPoint;
                }

                $userHomeData['goal'] += $game->away_goal;
                $userHomeData['conceded'] += $game->home_goal;
            }
        }

        /** away team calculate */
        foreach ($userAwayGame as $game) {
            if ($leagueGame->user_id_away == $game->user_id_home) {
                /** home game */
                if ($game->home_goal > $game->away_goal) {
                    $userAwayData['win']++;
                    $userAwayData['score'] += $winPoint;
                } elseif ($game->home_goal < $game->away_goal) {
                    $userAwayData['lose']++;
                } else {
                    $userAwayData['draw']++;
                    $userAwayData['score'] += $drawPoint;
                }

                $userAwayData['goal'] += $game->home_goal;
                $userAwayData['conceded'] += $game->away_goal;
            } else {
                /** away game */
                if ($game->home_goal < $game->away_goal) {
                    $userAwayData['win']++;
                    $userAwayData['score'] += $winPoint;
                } elseif ($game->home_goal > $game->away_goal) {
                    $userAwayData['lose']++;
                } else {
                    $userAwayData['draw']++;
                    $userAwayData['score'] += $drawPoint;
                }

                $userAwayData['goal'] += $game->away_goal;
                $userAwayData['conceded'] += $game->home_goal;
            }
        }

        DB::table('league_users')->where(['league_id'=>$leagueGame->league_id, 'user_id'=>$leagueGame->user_id_home])->update($userHomeData);
        DB::table('league_users')->where(['league_id'=>$leagueGame->league_id, 'user_id'=>$leagueGame->user_id_away])->update($userAwayData);
    }
}
