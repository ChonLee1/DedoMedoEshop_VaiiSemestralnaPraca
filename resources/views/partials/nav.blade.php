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
            <ul class="nav__links">
                <li><a href="{{ route('home') }}" class="nav__link {{ request()->routeIs('home') ? 'active' : '' }}">Domov</a></li>
                <li><a href="{{ route('products.index') }}" class="nav__link {{ request()->routeIs('products.*') ? 'active' : '' }}">Produkty</a></li>
                <li><a href="{{ route('contact.index') }}" class="nav__link {{ request()->routeIs('contact.*') ? 'active' : '' }}">Kontakt</a></li>
            </ul>
        </div>


        {{-- Cart icon with dynamic count; links to cart page --}}
        <a href="{{ route('cart.show') }}" class="cart-icon" aria-label="Open cart" title="Košík">
            🛒
            <span class="cart-count" style="margin-left: 4px; font-weight: 600;">0</span>
        </a>
    </div>
</nav>
