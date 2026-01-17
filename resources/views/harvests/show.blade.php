@extends('layouts.app')
@section('title', $harvestBatch->year . ' - ' . $harvestBatch->location . ' | DedoMedo e-shop')
@section('content')
    <div class="container">
        {{-- BACK BUTTON --}}
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('harvests.index') }}" class="btn btn--secondary">← Späť na zbierky</a>
        </div>

        {{-- HARVEST DETAIL --}}
        <section class="harvest-detail">
            <div class="harvest-detail__header">
                <div>
                    <h1 class="harvest-detail__title">{{ $harvestBatch->year }} - {{ $harvestBatch->location }}</h1>
                    <p class="harvest-detail__subtitle">Detailný popis zbierky</p>
                </div>
            </div>

            <div class="harvest-detail__info-grid">
                <div class="info-card">
                    <div class="info-card__icon">📅</div>
                    <div class="info-card__content">
                        <h3>Dátum zbierky</h3>
                        <p>{{ $harvestBatch->harvested_at->format('d. F Y') }}</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card__icon">📍</div>
                    <div class="info-card__content">
                        <h3>Miesto zbierky</h3>
                        <p>{{ $harvestBatch->location }}</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card__icon">📏</div>
                    <div class="info-card__content">
                        <h3>Hustota (Brix)</h3>
                        <p>{{ number_format($harvestBatch->brix, 1, ',', ' ') }}°</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card__icon">📦</div>
                    <div class="info-card__content">
                        <h3>Počet produktov</h3>
                        <p>{{ $harvestBatch->products->count() }} produktov</p>
                    </div>
                </div>
            </div>

            {{-- PRODUCTS FROM THIS BATCH --}}
            @if($harvestBatch->products->count() > 0)
                <section class="harvest-products-section" style="margin-top: 3rem;">
                    <h2 class="section-title">Produkty z tejto Zbierky</h2>

                    <div class="featured-grid">
                        @foreach($harvestBatch->products as $product)
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

                                <button class="btn btn--primary btn--sm" @disabled($product->stock <= 0)>
                                    Pridať do košíka
                                </button>
                            </div>
                        @endforeach
                    </div>
                </section>
            @else
                <div style="text-align: center; padding: 2rem; margin-top: 2rem; background: #f9fafb; border-radius: 0.75rem;">
                    <p class="text-muted">Z tejto zbierky zatiaľ nie sú dostupné žiadne aktívne produkty.</p>
                </div>
            @endif
        </section>
    </div>
@endsection

