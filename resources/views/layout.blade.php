<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="/home/bootstrap-5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/home/reset.css" rel="stylesheet" />
    <script src="/home/bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
<div id="app">
    @yield('content')
</div>
<p class="fw-light text-center text-body-tertiary p-2" style="font-size: 13px">- 宇联eスポーツ -</p>

@yield('script')

<script>
    const app = Vue.createApp(App);
    app.mount("#app");
</script>
</body>
</html>
