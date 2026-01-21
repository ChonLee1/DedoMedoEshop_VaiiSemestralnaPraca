@extends('layouts.app')
@section('title', $product->name . ' - DedoMedo')
@section('content')
<div class="container" style="margin: 3rem auto; max-width: 1200px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
        {{-- OBRÁZOK PRODUKTU --}}
        <div>
            @if($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}"
                     alt="{{ $product->name }}"
                     style="width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            @else
                <div style="width: 100%; height: 400px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 4rem;">🍯</span>
                </div>
            @endif
        </div>

        {{-- INFORMÁCIE O PRODUKTE --}}
        <div>
            <h1 style="margin-bottom: 1rem;">{{ $product->name }}</h1>

            @if($product->category)
                <p style="color: #999; margin-bottom: 1rem;">
                    🏷️ Kategória: <strong>{{ $product->category->name }}</strong>
                </p>
            @endif

            <div style="margin-bottom: 2rem;">
                <h2 style="color: #d4a574; font-size: 2rem;">
                    {{ number_format($product->price_cents / 100, 2) }} €
                </h2>
            </div>

            {{-- SKLADOVÁ DOSTUPNOSŤ --}}
            <div style="margin-bottom: 2rem;">
                @if($product->stock > 0)
                    <span style="background: #e8f5e9; color: #2e7d32; padding: 0.5rem 1rem; border-radius: 4px; display: inline-block;">
                        ✓ Skladom: {{ $product->stock }} ks
                    </span>
                @else
                    <span style="background: #ffebee; color: #c62828; padding: 0.5rem 1rem; border-radius: 4px; display: inline-block;">
                        ✗ Vypredané
                    </span>
                @endif
            </div>

            {{-- POPIS --}}
            <div style="margin-bottom: 2rem;">
                <h3>Popis produktu</h3>
                <p style="line-height: 1.6; color: #555;">
                    {{ $product->description ?? 'Tento produkt zatiaľ nemá dostupný popis.' }}
                </p>
            </div>

            {{-- PRIDAŤ DO KOŠÍKA --}}
            @if($product->stock > 0 && $product->is_active)
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                    <label for="quantity">Množstvo:</label>
                    <input type="number" id="quantity" min="1" max="{{ $product->stock }}" value="1"
                           style="width: 80px; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                    <button
                        class="btn btn-primary add-to-cart-btn"
                        data-product-id="{{ $product->id }}"
                        style="flex: 1; padding: 0.75rem 2rem; font-size: 1.1rem;">
                        🛒 Pridať do košíka
                    </button>
                </div>
            @else
                <button disabled class="btn btn-secondary" style="width: 100%; padding: 0.75rem;">
                    Produkt nie je dostupný
                </button>
            @endif

            {{-- DODATOČNÉ INFO --}}
            @if($product->harvestBatch)
                <div style="background: #fff3cd; padding: 1rem; border-radius: 4px; border-left: 4px solid #ffc107;">
                    <h4 style="margin-top: 0;">🌾 Informácie o zbierke</h4>
                    <p style="margin: 0;">
                        Rok: <strong>{{ $product->harvestBatch->year }}</strong><br>
                        Lokalita: <strong>{{ $product->harvestBatch->location }}</strong>
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- SPÄŤ NA PRODUKTY --}}
    <div style="margin-top: 3rem;">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
            ← Späť na produkty
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.querySelector('.add-to-cart-btn');
    if (!btn) return;

    btn.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const productName = '{{ $product->name }}';
        const price = {{ $product->price_cents / 100 }};
        const quantity = document.getElementById('quantity').value;

        if (typeof cart !== 'undefined') {
            cart.addItem(productId, productName, price, parseInt(quantity));
        } else {
            alert('Košík nie je inicializovaný');
        }
    });
});
</script>
@endsection

