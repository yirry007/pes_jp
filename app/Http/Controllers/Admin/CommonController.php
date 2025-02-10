<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cup;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    /**
     * schedule on main board
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function schedule(Request $request)
    {
        $return = array();

        $req = $request->only('year', 'month');

        $year = $req['year'] ?? date('Y');
        $month = $req['month'] ?? date('m');

        if ($month == 1) {
            $timeFrom = ($year - 1) . '-12-15 00:00:00';
            $timeTo = $year . '-' . ($month + 1) . '-15 23:59:59';
        } elseif ($month == 12) {
            $timeFrom = $year . '-' . ($month - 1) . '-15 00:00:00';
            $timeTo = ($year + 1) . '-01-15 23:59:59';
        } else {
            $timeFrom = $year . '-' . ($month - 1) . '-15 00:00:00';
            $timeTo = $year . '-' . ($month + 1) . '-15 23:59:59';
        }

        $leagueGames = DB::table('league_games')
            ->select([
                'league_games.*',
                'leagues.name as league_name',
                'user_home.nickname AS nickname_home',
                'user_home.head_image_url AS head_image_home',
                'user_away.nickname AS nickname_away',
                'user_away.head_image_url AS head_image_away',
            ])
            ->leftJoin('leagues', 'league_games.league_id', '=', 'leagues.id')
            ->leftJoin('users AS user_home', function($join){
                $join->on('league_games.user_id_home', '=', 'user_home.id');
            })
            ->leftJoin('users AS user_away', function($join){
                $join->on('league_games.user_id_away', '=', 'user_away.id');
            })
            ->whereBetween('game_time', [$timeFrom, $timeTo])
            ->orderBy('game_time', 'ASC')
            ->orderBy('league_games.id', 'ASC')
            ->get();

        $cupGames = DB::table('cup_games')
            ->select([
                'cup_games.*',
                'cups.name AS cup_name',
                'user_home.nickname AS nickname_home',
                'user_home.head_image_url AS head_image_home',
                'user_away.nickname AS nickname_away',
                'user_away.head_image_url AS head_image_away',
            ])
            ->leftJoin('cups', 'cup_games.cup_id', '=', 'cups.id')
            ->leftJoin('users AS user_home', function($join){
                $join->on('cup_games.user_id_home', '=', 'user_home.id');
            })
            ->leftJoin('users AS user_away', function($join){
                $join->on('cup_games.user_id_away', '=', 'user_away.id');
            })
            ->whereBetween('game_time', [$timeFrom, $timeTo])
            ->orderBy('game_time', 'ASC')
            ->orderBy('cup_games.id', 'ASC')
            ->get();

        $games = [];
        $index = 1;
        foreach ($leagueGames as $game) {
            $date = explode(' ', $game->game_time)[0];
            $game->index = $index;
            $game->time = substr($game->game_time, 11, 5);
            $games[$date][] = $game;
            $index++;
        }
        foreach ($cupGames as $game) {
            $date = explode(' ', $game->game_time)[0];
            $game->index = $index;
            $game->time = substr($game->game_time, 11, 5);
            $games[$date][] = $game;
            $index++;
        }

        $dateFrom = $year . '-01-01';
        $dateTo = $year . '-12-31';
        $leagues = League::whereBetween('start_date', [$dateFrom, $dateTo])->orderBy('start_date', 'ASC')->get();
        $cups = Cup::whereBetween('start_date', [$dateFrom, $dateTo])->orderBy('start_date', 'ASC')->get();

        $leagueCup = [];
        $index = 1;
        foreach ($leagues as $league) {
            $yearMonth = substr($league->start_date, 0, 7);
            $league->index = $index;
            $leagueCup[$yearMonth][] = $league;
            $index++;
        }
        foreach ($cups as $cup) {
            $yearMonth = substr($cup->start_date, 0, 7);
            $cup->index = $index;
            $leagueCup[$yearMonth][] = $cup;
            $index++;
        }

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result']['games'] = $games;
        $return['result']['league_cup'] = $leagueCup;

        return response()->json($return);
    }

    /**
     * image upload
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        set_time_limit(0);
        $return = array();
        $files = $request->file();
        $file = array_shift($files);

        $path = '';
        if($file->isValid()){
            $fileName = date('YmdHis').mt_rand(1000, 9999).'.'.$file->getClientOriginalExtension();
            $filePath = 'uploads/' . date('Ym');
            $savePath = public_path($filePath);
            $file->move($savePath, $fileName);

            $path = _url_($filePath.'/'.$fileName);
        }

        $return['code'] = '';
        $return['message'] = 'SUCCESS';
        $return['result'] = $path;

        return response()->json($return);
    }
}
