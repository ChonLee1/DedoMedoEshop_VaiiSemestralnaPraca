<nav class="nav" role="navigation" aria-label="Primary navigation">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo__icon" aria-hidden="true">🍯</div>
            <span class="logo__text">DedoMedo</span>
        </a>

        <button class="nav__toggle" aria-controls="nav-menu" aria-expanded="false" aria-label="Open menu">
            <span class="nav__burger" aria-hidden="true"></span>
        </button>

        <div id="nav-menu" class="nav__menu" role="region" aria-label="Main menu" aria-hidden="true">
            <button class="nav__close mobile-only" aria-label="Close menu">&times;</button>
            <ul class="nav__links">
                <li><a href="{{ route('home') }}" class="nav__link {{ request()->routeIs('home') ? 'active' : '' }}">Domov</a></li>
                <li><a href="{{ route('products.index') }}" class="nav__link {{ request()->routeIs('products.*') ? 'active' : '' }}">Produkty</a></li>
                <li><a href="#" class="nav__link">Zber</a></li>
                <li><a href="#" class="nav__link">Kontakt</a></li>
            </ul>
        </div>
        <a href="{{ route('login') }}" class="nav__link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
        <a href="#" class="cart-icon" aria-label="Open cart">🛒</a>
    </div>
</nav>
