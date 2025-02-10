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
                <a :class="{'nav-link': true, 'nav-ext': true, 'active': league.id === leagueId}" :href="'/league_ranking_view/'+league.id">@{{ league.name }}</a>
            </li>
        </ul>
    </div>
    <div class="text-center mb-4">
        <div class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="button" class="btn btn-outline-success btn-sm" @click="viewGames">試合</button>
            <button type="button" class="btn btn-success btn-sm">勝点</button>
        </div>
    </div>
    <table class="table table-borderless align-items-center">
        <thead>
        <tr class="bg-secondary-subtle">
            <th scope="col" class="fw-light" style="font-size:13px;">順位</th>
            <th scope="col" class="fw-light" style="font-size:13px;">氏名</th>
            <th scope="col" class="fw-light" style="font-size:13px;">回数</th>
            <th scope="col" class="fw-light" style="font-size:13px;">勝/分/負</th>
            <th scope="col" class="fw-light" style="font-size:13px;">得/失点</th>
            <th scope="col" class="fw-light" style="font-size:13px;">勝点</th>
        </tr>
        </thead>
        <tbody>
        <tr :style="{background: rankingBg[index] }" v-for="(item, index) in leagueRanking">
            <td style="font-size:13px;">@{{ index+1 }}</td>
            <td style="font-size:13px;">
                <a class="d-flex align-items-center" :href="'/user_games_view/'+item.user_id">
                    <div class="flex-shrink-0" style="width:28px;height:28px;">
                        <img :src="item.head_image_url" alt="..." style="border-radius: 5px;width: 100%;height:100%;object-fit: cover;">
                    </div>
                    <div class="flex-grow-1 ms-2">
                        @{{ item.nickname }}
                    </div>
                </a>
                <div style="padding-top: 2px;line-height:11px;" v-for="tag in JSON.parse(item.tags)">
                    <span class="badge text-bg-success" style="font-size:9px;font-weight:normal;">@{{ tag }}</span>
                </div>
            </td>
            <td style="font-size:13px;">@{{ item.games }}</td>
            <td style="font-size:13px;">@{{ item.win }}/@{{ item.draw }}/@{{ item.lose }}</td>
            <td style="font-size:13px;">@{{ item.goal }}/@{{ item.conceded }}</td>
            <td style="font-size:13px;">@{{ item.score }}</td>
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
                    leagueRanking: [],
                    rankingBg: ['#dbf2e0', '#f1fbf3', '#f8fdf9']
                };
            },
            mounted() {
                this.getLeagueRanking()
            },
            methods: {
                async getLeagueRanking() {
                    const response = await axios.get('{{ _url_('/league_ranking') }}/'+this.leagueId);
                    const res = response.data;
                    this.currentLeague = res.result.current_league;
                    this.leagues = res.result.leagues;
                    this.leagueRanking = res.result.league_ranking;
                },
                viewGames() {
                    window.location.href = '/league_games_view/' + this.leagueId;
                }
            }
        };
    </script>
@endsection
