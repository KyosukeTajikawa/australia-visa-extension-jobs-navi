<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AUSSIE FARM NAVIは、オーストラリア ワーホリ向けのファーム情報共有サイトです。実際に働いた人のレビューや評価を見ながら、安心してファームを探せます。" />
    <meta property="og:title" content="AUSSIE FARM NAVI" />
    <meta property="og:description" content="ワーホリ向けファーム検索サービス" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://aussie-farm-navi.com" />
    <meta property="og:image" content="https://aussie-farm-navi.com/images/farmMain.png" />

    <title inertia>{{ config('app.name', 'AUSSIE FARM NAVI') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" href="/favicon.ico">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.tsx', "resources/js/Pages/{$page['component']}.tsx"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
