@extends('layout')

@section('title', '比赛信息')

@section('content')
    <div class="p-3 mb-0 bg-danger bg-gradient text-white">
        <p class="h5">@{{ currentLeague.name }}</p>
        <p class="lead m-0">
            @{{ currentLeague.start_date }} ~ @{{ currentLeague.end_date }}
        </p>
    </div>
    <div class="bg-secondary-subtle mb-4">
        <ul class="nav">
            <li class="nav-item" v-for="league in leagues">
                <a :class="{'nav-link': true, 'nav-ext': true, 'active': league.id === leagueId}" :href="'/league_games_view/'+league.id">@{{ league.name }}</a>
            </li>
        </ul>
    </div>
    <div class="text-center mb-4">
        <div class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="button" class="btn btn-success btn-sm">赛程</button>
            <button type="button" class="btn btn-outline-success btn-sm" @click="viewRanking">积分</button>
        </div>
    </div>
    <table class="table table-borderless">
        <thead>
        <tr class="bg-secondary-subtle">
            <th scope="col" class="fw-light" style="font-size:13px;">时间</th>
            <th scope="col" class="fw-light" style="font-size:13px;text-align:center;">主队</th>
            <th scope="col" class="fw-light" style="font-size:13px;text-align:center;">比分</th>
            <th scope="col" class="fw-light" style="font-size:13px;text-align:center;">客队</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in leagueGames">
            <td style="font-size:13px;">@{{ item.game_time.substring(5, 16) }}</td>
            <td style="font-size:13px;">
                <a class="d-flex align-items-center" :href="'/user_games_view/'+item.user_id_home">
                    <div class="flex-grow-1" style="text-align:right;">
                        @{{ item.nickname_home }}
                    </div>
                    <div class="flex-shrink-0 ms-2" style="width:28px;height:28px;">
                        <img :src="item.head_image_home" alt="..." style="border-radius: 5px;width: 100%;height:100%;object-fit: cover;">
                    </div>
                </a>
                <div class="lh-1" style="padding: 2px;text-align:right;" v-for="tag in JSON.parse(item.tags_home)">
                    <span class="badge text-bg-success">@{{ tag }}</span>
                </div>
            </td>
            <td style="font-size:15px;text-align:center;font-weight:bold;">
                @{{ item.status === 1 ? item.home_goal : '' }} - @{{ item.status === 1 ? item.away_goal : '' }}
            </td>
            <td style="font-size:13px;">
                <a class="d-flex align-items-center" :href="'/user_games_view/'+item.user_id_away">
                    <div class="flex-shrink-0" style="width:28px;height:28px;">
                        <img :src="item.head_image_away" alt="..." style="border-radius: 5px;width: 100%;height:100%;object-fit: cover;">
                    </div>
                    <div class="flex-grow-1 ms-2">
                        @{{ item.nickname_away }}
                    </div>
                </a>
                <div class="lh-1" style="padding: 2px;" v-for="tag in JSON.parse(item.tags_away)">
                    <span class="badge text-bg-success">@{{ tag }}</span>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        const App = {
            data() {
                return {
                    leagueId: {{ request()->segment(2) }},
                    currentLeague: {},
                    leagues: [],
                    leagueGames: [],
                };
            },
            mounted() {
                this.getLeagueGames()
            },
            methods: {
                async getLeagueGames() {
                    const response = await axios.get('{{ _url_('/league_games') }}/'+this.leagueId);
                    const res = response.data;
                    this.currentLeague = res.result.current_league;
                    this.leagues = res.result.leagues;
                    this.leagueGames = res.result.league_games;
                },
                viewRanking() {
                    window.location.href = '/league_ranking_view/' + this.leagueId;
                }
            }
        };
    </script>
@endsection
