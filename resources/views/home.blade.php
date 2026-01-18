@extends('layouts.app')
@section('title','Domov - DedoMedo e-shop')
@section('content')

    {{-- HERO SEKCIA --}}
    <section class="hero">
        <div class="hero__content">
            <h1 class="hero__title">Vitaj v e-shope DedoMedo 🍯</h1>
            <p class="hero__subtitle">Ochutnaj kvalitný, čistý med priamo od včelára</p>
            <p class="hero__description">Vyrábame agátový, lipový, kvetový aj lesný med s osobitnou starostlivosťou a láskou.</p>
            <div class="hero__actions">
                <a class="btn btn--primary btn--lg" href="{{ route('products.index') }}">Objaviť produkty</a>
                <a class="btn btn--secondary btn--lg" href="#featured">Zistiť viac</a>
            </div>
        </div>
    </section>

    {{-- KATEGÓRIE SEKCIA --}}
    <section class="categories-section" id="categories">
        <div class="container">
            <h2 class="section-title">Naše Kategórie</h2>
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-card__icon">🍯</div>
                    <h3>Prírodné medy</h3>
                    <p>Výber čistých prírodných medov bez aditív</p>
                </div>
                <div class="category-card">
                    <div class="category-card__icon">🌼</div>
                    <h3>Kvetový med</h3>
                    <p>Zbieraný z rôznych kvetov počas leta</p>
                </div>
                <div class="category-card">
                    <div class="category-card__icon">🌳</div>
                    <h3>Lesný med</h3>
                    <p>Výnimočný med z lesných zdrojov</p>
                </div>
                <div class="category-card">
                    <div class="category-card__icon">🐝</div>
                    <h3>Medové produkty</h3>
                    <p>Produkty na báze medu a vosku</p>
                </div>
            </div>
        </div>
    </section>

    {{-- VYBRANÉ PRODUKTY --}}
    <section class="featured-section" id="featured">
        <div class="container">
            <h2 class="section-title">Naše Bestsellery</h2>
            <div class="featured-grid">
                @forelse($products ?? [] as $product)
                    <div class="product-card">
                        <div class="product-card__header">
                            <h3>{{ $product->name }}</h3>
                            @if($product->category)
                                <span class="badge">{{ $product->category->name }}</span>
                            @endif
                        </div>
                        @if($product->description)
                            <p class="product-card__description">{{ $product->description }}</p>
                        @endif
                        <div class="product-card__price">
                            {{ number_format($product->price_cents / 100, 2, ',', ' ') }} €
                        </div>
                        <div class="product-card__stock">
                            @if($product->stock > 0)
                                <span class="badge bg-success">Na sklade ({{ $product->stock }})</span>
                            @else
                                <span class="badge bg-danger">Vypredané</span>
                            @endif
                        </div>
                        <button
                            type="button"
                            class="btn btn--primary btn--sm"
                            @disabled($product->stock <= 0)
                            onclick="window.cart && window.cart.addItem(
                                {{ (int) $product->id }},
                                @js($product->name),
                                {{ (int) $product->price_cents }} / 100,
                                1
                            )"
                        >
                            Pridať do košíka
                        </button>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 2rem;">
                        <p class="text-muted">Produkty sa načítavajú...</p>
                        <a href="{{ route('products.index') }}" class="btn btn--primary mt-3">Pozrieť všetky produkty</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- VÝHODY --}}
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Prečo si vybrať DedoMedo?</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-card__icon">✓</div>
                    <h3>100% Prírodný</h3>
                    <p>Bez konzervantov, bez umelých ingrediencií. Iba čistý, kvalitný med.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-card__icon">🌍</div>
                    <h3>Lokálne Spracovanie</h3>
                    <p>Všetok med spracúvame a balíme sami s maximálnou starostlivosťou.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-card__icon">🚚</div>
                    <h3>Rýchle Doručenie</h3>
                    <p>Objednávka odídeme do 2 pracovných dní s bezpečným balením.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-card__icon">💚</div>
                    <h3>Podpora Prírody</h3>
                    <p>Staráme sa o včely a životné prostredie s maximálnym rešpektom.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CALL-TO-ACTION --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Začnite s DedoMedo Dnes</h2>
                <p>Nájdite svojho obľúbeného medu a objednajte si ho priamo domov.</p>
                <a href="{{ route('products.index') }}" class="btn btn--lg btn--primary">Ísť na produkty</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/cart.js') }}" defer></script>
@endpush

