@extends('layout')

@section('title', '宇联eスポーツ')

@section('content')
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button
                type="button"
                data-bs-target="#carouselExampleCaptions"
                :data-bs-slide-to="index"
                :class="{'active': index === 0}"
                aria-current="true"
                v-for="(banner, index) in banners"
            ></button>
        </div>
        <div class="carousel-inner">
            <a
                :class="{'carousel-item': true, 'active': index === 0}"
                v-for="(banner, index) in banners"
                :href="banner.url"
            >
                <img :src="banner.image" class="d-block w-100" alt="...">
                <div class="carousel-caption d-md-block">
                    <h5>@{{ banner.title }}</h5>
                    <p>@{{ banner.subject }}</p>
                </div>
            </a>
        </div>
    </div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item" v-for="item in news">
            <a :href="item.url" class="d-flex">
                <div class="flex-grow-1">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div>
                            <p class="h6 mb-1" style="font-size: 14px">@{{ item.title }}</p>
                            <p class="fw-light lh-sm mb-2" style="font-size: 12px">@{{ item.subject }}</p>
                        </div>
                        <p class="fw-light lh-sm mb-0 fs-6">@{{ item.create_at.substring(0, 16) }}</p>
                    </div>
                </div>
                <div class="flex-shrink-0 ms-3" style="width:100px;height:75px;">
                    <img :src="item.image" alt="..." style="width: 100%;height:100%;object-fit: cover;">
                </div>
            </a>
        </li>
    </ul>
@endsection

@section('script')
    <script>
        const App = {
            data() {
                return {
                    banners: [],
                    news: [],
                };
            },
            mounted() {
                this.getNews()
            },
            methods: {
                async getNews() {
                    const response = await axios.get('{{ _url_('/get_news') }}');
                    const res = response.data;
                    this.banners = res.result.banners;
                    this.news = res.result.news;
                }
            }
        };
    </script>
@endsection
