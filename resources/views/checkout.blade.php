{{--Pomoc S AI--}}
@extends('layouts.app')
@section('title','Pokladňa - DedoMedo e-shop')
@section('content')
    <div class="container" style="margin: 3rem auto; max-width: 1200px;">
        <h1 style="margin-bottom: 2rem;">🛒 Pokladňa</h1>

        @if (session('success'))
            <div style="background: #efe; border: 1px solid #cfc; color: #060; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('order'))
            <div style="text-align: center; margin-bottom: 3rem; padding: 2rem; background: #f0f8ff; border-radius: 8px;">
                <h2 style="color: #2ecc71; margin-bottom: 1rem;">🎉 Objednávka potvrdená!</h2>
                <p style="font-size: 1.2rem; margin-bottom: 1.5rem;">Kód Vašej objednávky: <strong style="color: #d4a574;">{{ session('order')->code }}</strong></p>
                <p style="color: #666; margin-bottom: 2rem;">Na vašu emailovú adresu sme poslali potvrdzujúcu správu.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem; text-decoration: none; color: white; background: #d4a574; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    ← Pokračovať v nákupe
                </a>
            </div>

            <!-- Po úspešnej objednávke vyprázdni košík (localStorage) a aktualizuj UI -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    try {
                        if (window.cart && typeof window.cart.clearCart === 'function') {
                            window.cart.clearCart();
                        } else {
                            localStorage.removeItem('dedomedo_cart');
                            const countEl = document.querySelector('.cart-count');
                            if (countEl) countEl.textContent = '0';
                        }
                    } catch (e) {
                        localStorage.removeItem('dedomedo_cart');
                    }
                });
            </script>
        @endif

        @if ($errors->any())
            <div style="background: #fee; border: 1px solid #fcc; color: #c00; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
                <h4>Chyba pri odslaní objednávky</h4>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!session('order'))
            {{-- KOŠÍK --}}
            <div>
                <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px;">
                    <h3 style="margin-bottom: 1.5rem;">📦 Tvoj Košík</h3>
                    <div id="cart-items">
                        <p style="color: #999; text-align: center;">Načítavám košík...</p>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #ddd;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <strong>Celkem:</strong>
                            <h2 style="color: #d4a574; margin: 0;" id="total-price">0.00 €</h2>
                        </div>
                        <button onclick="cart.clearCart()" class="btn btn-outline-danger" style="width: 100%;">
                            Vyprázdniť košík
                        </button>
                    </div>
                </div>
            </div>

            {{-- OBJEDNÁVKA FORMULÁR --}}
            <div>
                <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px;">
                    <h3 style="margin-bottom: 1.5rem;">📝 Údaje Objednávky</h3>

                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <div style="margin-bottom: 1.5rem;">
                            <label for="customer_name" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Meno *</label>
                            <input
                                type="text"
                                id="customer_name"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                                placeholder="Vaše meno"
                            >
                            @error('customer_name')
                                <span style="color: #c00; font-size: 0.9rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="email" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Email *</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                                placeholder="vasa@email.com"
                            >
                            @error('email')
                                <span style="color: #c00; font-size: 0.9rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="phone" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Telefón *</label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                                placeholder="+421 1 234 5678"
                            >
                            @error('phone')
                                <span style="color: #c00; font-size: 0.9rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 1.5rem;">

                        {{-- Skrytý field pre cart items --}}
                        <input type="hidden" id="cart_items" name="cart_items" value="">

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem; cursor: pointer;">
                            Potvrdiť Objednávku 🎉
                        </button>
                        </div>
                    </form>
                </div>
            </div>

        <div style="margin-top: 2rem;">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">← Pokračovať v nákupe</a>
        </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                if (!window.cart || window.cart.getItemCount() === 0) {
                    e.preventDefault();
                    alert('Košík je prázdny! Pridaj produkty pred objednávkou.');
                    return false;
                }
                const hidden = document.getElementById('cart_items');
                if (hidden) hidden.value = window.cart.exportForCheckout();
            });
        });
    </script>
@endsection
