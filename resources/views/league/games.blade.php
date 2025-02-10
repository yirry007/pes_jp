@extends('layout')

@section('title', '試合情報')

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
            <button type="button" class="btn btn-success btn-sm">試合</button>
            <button type="button" class="btn btn-outline-success btn-sm" @click="viewRanking">勝点</button>
        </div>
    </div>
    <div v-for="(games, date) in leagueGames">
        <div
            class="p-3 bg-secondary-subtle d-flex justify-content-between"
            :class="'game-date date-'+date"
            style="font-size:16px;border-bottom:1px solid #ffffff"
        >
            <span>@{{ date }}</span>
            <a style="font-size:12px;color:#ababab" data-bs-toggle="collapse" :href="'#collapseModule'+date">見る</a>
        </div>
        <ul
            class="list-group list-group-flush collapse"
            :class="parseInt(date.replaceAll('-', '')) >= currentDate() ? 'show' : ''"
            :id="'collapseModule'+date"
        >
            <li class="list-group-item" v-for="game in games">
                <div class="row mb-1">
                    <div class="col-1 p-0"></div>
                    <div class="col-4 p-0" style="font-size:12px;color:#ababab">@{{ game.game_time.substring(5, 16) }}</div>
                    <div class="col-7 p-0" style="font-size:12px;color:#ababab"></div>
                </div>
                <div class="row">
                    <div class="col-1 p-0"></div>
                    <div class="col-4 p-0">
                        <a class="d-flex align-items-center" :href="'/user_games_view/'+game.user_id_home">
                            <div class="flex-grow-1" style="text-align:right;font-size:13px;">
                                @{{ game.nickname_home }}
                            </div>
                            <div class="flex-shrink-0 ms-2" style="width:28px;height:28px;">
                                <img :src="game.head_image_home" alt="..." style="border-radius: 5px;width: 100%;height:100%;object-fit: cover;">
                            </div>
                        </a>
                        <div style="padding-top: 1px;line-height:11px;text-align:right;" v-for="tag in JSON.parse(game.tags_home)">
                            <span class="badge text-bg-success" style="font-size:9px;font-weight:normal;">@{{ tag }}</span>
                        </div>
                    </div>
                    <div class="col-2 p-0" style="text-align:center;">
                        <div style="font-size:18px;font-weight:bold;">
                            @{{ game.status === 1 ? game.home_goal : '' }} - @{{ game.status === 1 ? game.away_goal : '' }}
                        </div>
                        <p class="m-0" style="font-size:12px;color:#aeaeae" v-if="game.home_goal_penalty">点球</p>
                    </div>
                    <div class="col-4 p-0">
                        <a class="d-flex align-items-center" :href="'/user_games_view/'+game.user_id_away">
                            <div class="flex-shrink-0" style="width:28px;height:28px;">
                                <img :src="game.head_image_away" alt="..." style="border-radius: 5px;width: 100%;height:100%;object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-2" style="font-size:13px;">
                                @{{ game.nickname_away }}
                            </div>
                        </a>
                        <div style="padding-top: 1px;line-height:11px;" v-for="tag in JSON.parse(game.tags_away)">
                            <span class="badge text-bg-success" style="font-size:9px;font-weight:normal;">@{{ tag }}</span>
                        </div>
                    </div>
                    <div class="col-1 p-0"></div>
                </div>
            </li>
        </ul>
    </div>
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

                    setTimeout(() => {
                        this.scrollToAnchor();
                    }, 1000);
                },
                viewRanking() {
                    window.location.href = '/league_ranking_view/' + this.leagueId;
                },
                scrollToAnchor() {
                    const D = new Date();
                    const year = D.getFullYear();
                    const month = (D.getMonth() + 1).toString().padStart(2, '0');
                    const day = D.getDate().toString().padStart(2, '0');
                    const today = parseInt(`${year}${month}${day}`);

                    let nextDayElement;
                    const gameDates = document.querySelectorAll('.game-date');
                    loopDate: for (let i=0;i<gameDates.length;i++) {
                        const classList = Array.from(gameDates[i].classList);

                        for (let j=0;j<classList.length;j++) {
                            if (!classList[j].includes('date')) continue;

                            const nextDate = classList[j].replace(/\D+/g, "");

                            if (nextDate >= today) {
                                nextDayElement = gameDates[i];
                                break loopDate;
                            }
                        }
                    }

                    if (nextDayElement) {
                        nextDayElement.scrollIntoView({ behavior: 'smooth' });
                    }
                },

                currentDate() {
                    let currentDate = new Date();
                    let year = currentDate.getFullYear();
                    let month = currentDate.getMonth() + 1;
                    month = month < 10 ? '0' + month : month;
                    let day = currentDate.getDate();
                    day = day < 10 ? '0' + day : day;

                    return parseInt(year + month + day);
                }
            }
        };
    </script>
@endsection
