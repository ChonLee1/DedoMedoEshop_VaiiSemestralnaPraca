@extends('layouts.app')

@section('title', 'Produkty')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Naše produkty</h1>

        {{-- Filter formulár --}}
        <div class="product-filter" style="background: #fef5e7; border: 2px solid #d4a574; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <div class="filter-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label for="category-filter" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Kategória:</label>
                    <select id="category-filter" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                        <option value="">-- Všetky kategórie --</option>
                        @forelse($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @empty
                            <option disabled>Žiadne kategórie</option>
                        @endforelse
                    </select>
                </div>
                <div>
                    <label for="search-filter" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Hľadať:</label>
                    <input type="text" id="search-filter" placeholder="Hľadaj produkt..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                </div>
            </div>
        </div>

        {{-- Zoznam produktov --}}
        <div id="products-list" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; margin-top: 2rem;">
            @forelse($products ?? [] as $product)
                @if($product->is_active)
                    <div style="background: white; border: 1px solid #eee; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)';">

                        {{-- Obrázok produktu --}}
                        <div style="width: 100%; height: 200px; background: #f5f5f5; overflow: hidden;">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}"
                                     alt="{{ $product->name }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #eee; color: #999; font-size: 3rem;">
                                    📦
                                </div>
                            @endif
                        </div>

                        {{-- Obsah --}}
                        <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                            {{-- Kategória --}}
                            <span style="display: inline-block; background: #d4a574; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; margin-bottom: 0.75rem; width: fit-content;">
                                {{ $product->category?->name ?? 'Bez kategórie' }}
                            </span>

                            {{-- Názov --}}
                            <h3 style="margin: 0.75rem 0; font-size: 1.3rem; color: #333; flex-grow: 1;">
                                {{ $product->name }}
                            </h3>

                            {{-- Popis --}}
                            <p style="color: #666; font-size: 0.95rem; margin: 0.75rem 0; line-height: 1.4;">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            {{-- Cena a skladem --}}
                            <div style="display: flex; justify-content: space-between; align-items: center; margin: 1rem 0; padding-top: 1rem; border-top: 1px solid #eee;">
                                <span style="font-size: 1.5rem; font-weight: bold; color: #d4a574;">
                                    {{ number_format($product->price_cents / 100, 2, ',', ' ') }} €
                                </span>
                                <span style="font-size: 0.9rem; color: {{ $product->stock > 0 ? '#4caf50' : '#d32f2f' }};">
                                    {{ $product->stock > 0 ? "📦 " . $product->stock . " ks" : "❌ Vypredané" }}
                                </span>
                            </div>

                            {{-- Tlačidlo detaily --}}
                            <a href="{{ route('product.show', $product) }}"
                               style="display: block; width: 100%; padding: 0.75rem; text-align: center; background: #d4a574; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; transition: background 0.2s;"
                               onmouseover="this.style.background='#c49564';"
                               onmouseout="this.style.background='#d4a574';">
                                Zobraziť detaily
                            </a>
                        </div>
                    </div>
                @endif
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
                    <p style="color: #999; font-size: 1.1rem;">Žiadne produkty nie sú dostupné.</p>
                </div>
            @endforelse
