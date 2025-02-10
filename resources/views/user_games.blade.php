@extends('layout')

@section('title', 'ユーザー情報')

@section('content')
    <div class="p-3 mb-0 bg-danger bg-gradient text-white d-flex">
        <div class="flex-grow-1">
            <p class="h5">@{{ user.nickname }}</p>
            <div style="font-size:12px;color:#eaeaea" v-for="tag in tags">
                @{{ tag }}
            </div>
        </div>
        <div class="flex-shrink-0 ms-3" style="width:80px;height:80px;">
            <img :src="user.head_image_url" alt="..." style="border-radius: 8px;width: 100%;height:100%;object-fit: cover;">
        </div>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <a
                :class="{'nav-link':true, 'nav-ext':true, 'active': !leagueId && !cupId}"
                :href="'/user_games_view/' + userId"
            >すべて</a>
        </li>
        <li class="nav-item" v-for="item in leagueCups">
            <a
                :class="{'nav-link':true, 'nav-ext':true, 'active': leagueId == item.league_id || cupId == item.cup_id}"
                href="javascript:void(0);"
                @click="searchUserGames({league_id:item.league_id, cup_id:item.cup_id})"
            >@{{ item.name }}</a>
        </li>
    </ul>
    <div v-for="(games, date) in userGames">
        <div
            class="p-3 bg-secondary-subtle d-flex justify-content-between"
            style="font-size:16px;border-bottom:1px solid #ffffff"
        >
            <span>@{{ date }}</span>
            <a style="font-size:12px;color:#ababab" data-bs-toggle="collapse" :href="'#collapseModule'+date">見る</a>
        </div>
        <ul
            class="list-group list-group-flush collapse"
            :class="parseInt(date.replaceAll('-', '')) >= currentDate() ? 'show' : ''"
            :id="'collapseModule'+date"
            style="border-bottom:1px solid #ffffff"
        >
            <li class="list-group-item" v-for="game in games">
                <div class="row mb-3">
                    <div class="col-1 p-0"></div>
                    <div class="col-4 p-0" style="font-size:12px;color:#ababab">@{{ game.game_time.substring(5, 16) }}</div>
                    <div class="col-7 p-0" style="font-size:12px;color:#ababab">@{{ game.game_name }}</div>
                </div>
                <div class="row">
                    <div class="col-1 p-0"></div>
                    <div class="col-4 p-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1" style="text-align:right;font-size:13px;">
                                @{{ game.nickname_home }}
                            </div>
                            <div class="flex-shrink-0 ms-2" style="width:28px;height:28px;">
                                <img :src="game.head_image_home" alt="..." style="border-radius: 5px;width: 100%;height:100%;object-fit: cover;">
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-0" style="text-align:center;">
                        <div style="font-size:18px;font-weight:bold;">
                            @{{ game.status === 1 ? game.home_goal : '' }} - @{{ game.status === 1 ? game.away_goal : '' }}
                        </div>
                        <p class="m-0" style="font-size:12px;color:#aeaeae" v-if="game.home_goal_penalty">PK</p>
                    </div>
                    <div class="col-4 p-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0" style="width:28px;height:28px;">
                                <img :src="game.head_image_away" alt="..." style="border-radius: 5px;width: 100%;height:100%;object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-2" style="font-size:13px;">
                                @{{ game.nickname_away }}
                            </div>
                        </div>
                    </div>
                    <div class="col-1 p-0">
                        <span
                            v-if="game.status === 1"
                            :class="{'badge': true, 'rounded-pill': true, [calcResult(game)['className']]: true}"
                        >
                            @{{ calcResult(game)['text'] }}
                        </span>
                    </div>
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
                    userId: {{ request()->segment(2) }},
                    leagueId: '{{ $leagueId }}',
                    cupId: '{{ $cupId }}',
                    user: {},
                    tags: [],
                    leagueCups: [],
                    userGames: {},
                };
            },
            mounted() {
                this.getUserGames()
            },
            methods: {
                async getUserGames() {
                    const response = await axios.get('{{ _url_('/user_games') }}/' + this.userId + '?league_id=' + this.leagueId + '&cup_id=' + this.cupId);
                    const res = response.data;
                    this.user = res.result.user;
                    this.tags = JSON.parse(this.user.tags);
                    this.leagueCups = res.result.league_cups;
                    this.userGames = res.result.user_games;
                },

                searchUserGames(params) {
                    const leagueId = params.league_id ? params.league_id : '';
                    const cupId = params.cup_id ? params.cup_id : '';
                    window.location.href = '/user_games_view/' + this.userId + '?league_id=' + leagueId + '&cup_id=' + cupId;
                },

                calcResult(game) {
                    const result = {className: 'text-bg-danger', text: '勝'};

                    if ((this.userId === game.user_id_home && game.difference > 0) || (this.userId === game.user_id_away && game.difference < 0)) {
                        return result;
                    }
                    if ((this.userId === game.user_id_home && game.difference < 0) || (this.userId === game.user_id_away && game.difference > 0)) {
                        result.className = 'text-bg-primary';
                        result.text = '負';
                        return result;
                    }
                    if (game.difference === 0) {
                        result.className = 'text-bg-success';
                        result.text = '分';
                        return result;
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
