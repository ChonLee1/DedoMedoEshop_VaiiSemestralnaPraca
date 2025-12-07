<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Admin') - DedoMedo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="bg-dark text-white py-3 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    DedoMedo Admin
                </a>
            </h2>
            <nav>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link text-white">Kategórie</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white-50">{{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light">Odhlásiť</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="mt-5 py-3 bg-light">
    <div class="container text-center text-muted">
        <small>&copy; {{ date('Y') }} DedoMedo - Admin Panel</small>
    </div>
</footer>

@stack('scripts')
</body>
</html>

