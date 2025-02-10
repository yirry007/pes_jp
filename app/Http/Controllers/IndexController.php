<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\News;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * display index page
     * @return View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * get news data
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNews()
    {
        $banners = News::where(['is_banner'=>'1', 'is_use'=>'1'])->orderBy('sort', 'DESC')->orderBy('create_at', 'DESC')->limit(5)->get();
        $news = News::where(['is_banner'=>'0', 'is_use'=>'1'])->orderBy('sort', 'DESC')->orderBy('create_at', 'DESC')->limit(20)->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['banners'] = $banners;
        $return['result']['news'] = $news;

        return response()->json($return);
    }

    /**
     * display league ranking page
     * @param $leagueId
     * @return View
     */
    public function leagueRankingView($leagueId)
    {
        return view('league.ranking');
    }

    /**
     * get league ranking data
     * @param $leagueId
     * @return \Illuminate\Http\JsonResponse
     */
    public function leagueRanking($leagueId)
    {
        $currentLeague = League::find($leagueId);
        $leagues = League::where('is_del', '0')->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->limit(8)->get();

        $leagueRanking = DB::table('league_users')
            ->select(DB::raw('
                league_users.*,
                users.nickname,
                users.head_image_url,
                users.tags,
                (league_users.goal - league_users.conceded) AS difference')
            )
            ->leftJoin('users', 'league_users.user_id', '=', 'users.id')
            ->where(['league_id'=>$leagueId, 'status'=>1])
            ->orderBy('score', 'DESC')
            ->orderBy('difference', 'DESC')
            ->orderBy('goal', 'DESC')
            ->get();

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['current_league'] = $currentLeague;
        $return['result']['leagues'] = $leagues;
        $return['result']['league_ranking'] = $leagueRanking;

        return response()->json($return);
    }

    /**
     * display league game page
     * @param $leagueId
     * @return View
     */
    public function leagueGamesView($leagueId)
    {
        return view('league.games');
    }

    /**
     * get league game data
     * @param $leagueId
     * @return \Illuminate\Http\JsonResponse
     */
    public function leagueGames($leagueId)
    {
        $currentLeague = League::find($leagueId);
        $leagues = League::where('is_del', '0')->orderBy('start_date', 'DESC')->orderBy('id', 'DESC')->limit(8)->get();

        $leagueGames = DB::table('league_games')
            ->select([
                'league_games.*',
                'user_home.nickname AS nickname_home',
                'user_home.head_image_url AS head_image_home',
                'user_home.tags AS tags_home',
                'user_away.nickname AS nickname_away',
                'user_away.head_image_url AS head_image_away',
                'user_away.tags AS tags_away',
            ])
            ->leftJoin('users AS user_home', function($join){
                $join->on('league_games.user_id_home', '=', 'user_home.id');
            })
            ->leftJoin('users AS user_away', function($join){
                $join->on('league_games.user_id_away', '=', 'user_away.id');
            })
            ->where('league_id', $leagueId)
            ->whereRaw('TIME(league_games.game_time) != "00:00:00"')
            ->orderBy('game_time', 'ASC')
            ->orderBy('league_games.id', 'ASC')
            ->get();

        $leagueGamesGroupedByDate = array();
        foreach ($leagueGames as $game) {
            $date = explode(' ', $game->game_time)[0];
            $leagueGamesGroupedByDate[$date][] = $game;
        }

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['current_league'] = $currentLeague;
        $return['result']['leagues'] = $leagues;
        $return['result']['league_games'] = $leagueGamesGroupedByDate;

        return response()->json($return);
    }

    /**
     * display user games page
     * @param Request $request
     * @param $userId
     * @return View
     */
    public function userGamesView(Request $request, $userId)
    {
        $req = $request->only('league_id', 'cup_id');
        $leagueId = $req['league_id'] ?? '';
        $cupId = $req['cup_id'] ?? '';

        return view('user_games', compact('leagueId', 'cupId'));
    }

    /**
     * get user game page
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function userGames(Request $request, $id)
    {
        $req = $request->only('league_id', 'cup_id');
        $leagueId = array_val('league_id', $req);
        $cupId = array_val('cup_id', $req);

        $user = User::select(['nickname', 'head_image_url', 'tags'])->find($id);

        $leagues = DB::table('league_users')
            ->select(['leagues.id', 'leagues.name', 'leagues.start_date', 'league_id'])
            ->leftJoin('leagues', 'league_users.league_id', '=', 'leagues.id')
            ->where(['user_id'=>$id, 'status'=>1, 'leagues.is_del'=>0])
            ->orderBy('start_date', 'DESC')
            ->orderBy('leagues.id', 'DESC')
            ->groupBy('league_id')
            ->limit(8)
            ->get()->toArray();

        $cups = DB::table('cup_users')
            ->select(['cups.id', 'cups.name', 'cups.start_date', 'cup_id'])
            ->leftJoin('cups', 'cup_users.cup_id', '=', 'cups.id')
            ->where(['user_id'=>$id, 'status'=>1, 'cups.is_del'=>0])
            ->orderBy('start_date', 'DESC')
            ->orderBy('cups.id', 'DESC')
            ->groupBy('cup_id')
            ->limit(8)
            ->get()->toArray();

        $leagueCups = array_merge($leagues, $cups);
        usort($leagueCups, function($a, $b) {
            return strtotime($b->start_date . ' 00:00:00') - strtotime($a->start_date . ' 00:00:00');
        });

        $leagueGames = DB::table('league_games')
            ->select(DB::raw('
                league_games.*,
                leagues.name AS game_name,
                user_home.nickname AS nickname_home,
                user_home.head_image_url AS head_image_home,
                user_away.nickname AS nickname_away,
                user_away.head_image_url AS head_image_away,
                home_goal - away_goal AS difference
            '))
            ->leftJoin('leagues', 'league_games.league_id', '=', 'leagues.id')
            ->leftJoin('users AS user_home', function($join){
                $join->on('league_games.user_id_home', '=', 'user_home.id');
            })
            ->leftJoin('users AS user_away', function($join){
                $join->on('league_games.user_id_away', '=', 'user_away.id');
            })
            ->where('leagues.is_del', '0')
            ->whereRaw('TIME(league_games.game_time) != "00:00:00"')
            ->where(function ($query) use ($id) {
                $query->orWhere('league_games.user_id_home', $id);
                $query->orWhere('league_games.user_id_away', $id);
            })
            ->where(function ($query) use ($leagueId, $cupId) {
                if ($cupId) {//有杯赛筛选，则不查询联赛
                    $query->where('league_games.id', 0);
                } else {
                    if ($leagueId) {
                        $query->where('league_games.league_id', $leagueId);
                    }
                }
            })
            ->orderBy('game_time', 'DESC')
            ->orderBy('league_games.id', 'DESC')
            ->get()->toArray();

        $cupGames = DB::table('cup_games')
            ->select(DB::raw('
                cup_games.*,
                cups.name AS game_name,
                user_home.nickname AS nickname_home,
                user_home.head_image_url AS head_image_home,
                user_away.nickname AS nickname_away,
                user_away.head_image_url AS head_image_away,
                (home_goal + home_goal_penalty) - (away_goal + away_goal_penalty) AS difference
            '))
            ->leftJoin('cups', 'cup_games.cup_id', '=', 'cups.id')
            ->leftJoin('users AS user_home', function($join){
                $join->on('cup_games.user_id_home', '=', 'user_home.id');
            })
            ->leftJoin('users AS user_away', function($join){
                $join->on('cup_games.user_id_away', '=', 'user_away.id');
            })
            ->where('cups.is_del', '0')
            ->whereRaw('TIME(cup_games.game_time) != "00:00:00"')
            ->where(function ($query) use ($id) {
                $query->orWhere('cup_games.user_id_home', $id);
                $query->orWhere('cup_games.user_id_away', $id);
            })
            ->where(function ($query) use ($leagueId, $cupId) {
                if ($leagueId) {//有联赛筛选，则不查询杯赛
                    $query->where('cup_games.id', 0);
                } else {
                    if ($cupId) {
                        $query->where('cup_games.cup_id', $cupId);
                    }
                }
            })
            ->orderBy('game_time', 'DESC')
            ->orderBy('cup_games.id', 'DESC')
            ->get()->toArray();

        $userGames = array_merge($leagueGames, $cupGames);
        usort($userGames, function($a, $b) {
            return strtotime($b->game_time) - strtotime($a->game_time);
        });

        $userGamesGroupedByDate = array();
        foreach ($userGames as $game) {
            $date = explode(' ', $game->game_time)[0];
            $userGamesGroupedByDate[$date][] = $game;
        }

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['user'] = $user;
        $return['result']['league_cups'] = $leagueCups;
        $return['result']['user_games'] = $userGamesGroupedByDate;

        return response()->json($return);
    }
}
