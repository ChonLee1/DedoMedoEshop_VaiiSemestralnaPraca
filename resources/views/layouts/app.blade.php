<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>@yield('title','DedoMedo e-shop')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<header class="site-header">
    @include('partials.nav')
</header>

<main class="container">
    @yield('content')
</main>

<footer class="site-footer">
    @include('partials.footer')
</footer>

@stack('scripts')
</body>
</html>
