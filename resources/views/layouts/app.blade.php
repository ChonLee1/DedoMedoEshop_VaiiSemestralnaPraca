<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    {{-- Title – ak child view nenastaví @section('title'), použije sa „DedoMedo e-shop“ --}}
    <title>@yield('title','DedoMedo e-shop')</title>

    {{-- Vite bundle – načítanie hlavného CSS a JS (hot-reload v dev, verzovanie v prod) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<header class="site-header">
    {{-- Horná navigácia/hlavička – partial pre opakované použitie --}}
    @include('partials.nav')
</header>

<main class="container">
    {{-- Hlavný obsah stránky – vyplní sa z child view cez @section('content') --}}
    @yield('content')
</main>

<footer class="site-footer">
    {{-- Päta webu – partial s kontaktom, sociálnymi sieťami atď. --}}
    @include('partials.footer')
</footer>

{{-- Miesto pre doplnkové skripty „pushnuté“ z child view (napr. stránkové JS) --}}
@stack('scripts')
</body>
</html>
