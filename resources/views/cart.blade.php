@extends('layouts.app')
@section('title', 'Nákupný košík')
@section('content')
<div class="container" style="margin: 3rem auto; max-width: 1000px;">
    <h1 style="margin-bottom: 2rem;">🛒 Nákupný košík</h1>

    {{-- POLOŽKY KOŠÍKA --}}
    <div id="cart-items-container" style="background: #f9f9f9; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
        <div id="cart-items">
            <p style="text-align: center; color: #999;">Načítavam košík...</p>
        </div>
    </div>

    {{-- CELKOVÁ SUMA --}}
    <div style="background: #e8f5e9; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0;">Celková suma:</h3>
            <h2 id="cart-total-price" style="color: #4caf50; margin: 0; font-size: 2rem;">0.00 €</h2>
        </div>
    </div>

    {{-- AKCIE --}}
    <div style="display: flex; gap: 1rem; justify-content: space-between;">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
            ← Pokračovať v nákupe
        </a>
        <div style="display: flex; gap: 1rem;">
            <button onclick="if(cart) cart.clearCart();" class="btn btn-outline-danger">
                🗑️ Vyprázdniť košík
            </button>
            <a href="{{ route('checkout.show') }}" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                Pokračovať na objednávku →
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aktualizuj zobrazenie košíka
    if (typeof cart !== 'undefined') {
        const container = document.getElementById('cart-items');
        const totalEl = document.getElementById('cart-total-price');

        if (container) {
            cart.renderCartItems(container);
        }
        if (totalEl) {
            totalEl.textContent = cart.getTotalPrice().toFixed(2) + ' €';
        }
    }
});
</script>
@endsection

