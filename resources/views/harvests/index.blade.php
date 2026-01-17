@extends('layouts.app')
@section('title','Zbierky - DedoMedo e-shop')
@section('content')
    <div class="container">
        {{-- HERO SEKCIA --}}
        <section class="hero" style="margin-bottom: 3rem;">
            <div class="hero__content">
                <h1 class="hero__title">Naše Zbierky Medov 🍯</h1>
                <p class="hero__subtitle">Pozrite si históriu a zdroje nášho medu</p>
                <p class="hero__description">Každá zbierka má svoju vlastnú históriu, miesto a kvalitu. Zistite viac o každej z nich.</p>
            </div>
        </section>

        {{-- BATCHES SEKCIA --}}
        <section class="harvests-section" style="padding: 2rem 0;">
            <h2 class="section-title">Všetky Zbierky</h2>

            @forelse($batches as $batch)
                <div class="harvest-card">
                    <div class="harvest-card__header">
                        <div>
                            <h3 class="harvest-card__title">{{ $batch->year }} - {{ $batch->location }}</h3>
                            <p class="harvest-card__date">
                                📅 Zbierka: {{ $batch->harvested_at->format('d.m.Y') }}
                            </p>
                        </div>
                        <div class="harvest-card__badge">
                            <span class="badge">{{ $batch->products_count }} produktov</span>
                        </div>
                    </div>

                    <div class="harvest-card__body">
                        <div class="harvest-card__info">
                            <div class="harvest-info-item">
                                <span class="harvest-info-label">📍 Miesto:</span>
                                <span class="harvest-info-value">{{ $batch->location }}</span>
                            </div>
                            <div class="harvest-info-item">
                                <span class="harvest-info-label">📏 Brix (hustota):</span>
                                <span class="harvest-info-value">{{ number_format($batch->brix, 1, ',', ' ') }}°</span>
                            </div>
                            <div class="harvest-info-item">
                                <span class="harvest-info-label">🎯 Rok:</span>
                                <span class="harvest-info-value">{{ $batch->year }}</span>
                            </div>
                        </div>

                        <div class="harvest-card__products">
                            @if($batch->products_count > 0)
                                <p class="harvest-products-title">📦 Produkty z tejto zbierky:</p>
                                <ul class="harvest-products-list">
                                    @foreach($batch->products as $product)
                                        <li>
                                            <a href="{{ route('products.index') }}" class="harvest-product-link">
                                                {{ $product->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Zatiaľ žiadne produkty z tejto zbierky.</p>
                            @endif
                        </div>
                    </div>

                    <div class="harvest-card__footer">
                        <a href="{{ route('harvests.show', $batch) }}" class="btn btn--primary">
                            Viac detailov
                        </a>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem;">
                    <p class="text-muted">Zatiaľ žiadne zbierky.</p>
                </div>
            @endforelse
        </section>
    </div>
@endsection

