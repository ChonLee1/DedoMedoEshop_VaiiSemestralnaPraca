@extends('layouts.app')
@section('title', 'Správa produktov')
@section('content')
    <div class="container" style="margin: 3rem auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>📦 Správa produktov</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Späť</a>
        </div>

        @if(session('success'))
            <div style="background: #e8f5e9; border: 1px solid #4caf50; color: #2e7d32; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #ffebee; border: 1px solid #f44336; color: #c62828; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <strong>Chyba:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulár na pridanie nového produktu --}}
        <div style="background: #f0f7ff; border: 2px solid #2196f3; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="margin-top: 0;">➕ Pridať nový produkt</h3>

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Názov produktu *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    </div>

                    <div>
                        <label for="category_id" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Kategória *</label>
                        <select id="category_id" name="category_id" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                            <option value="">-- Vyber kategóriu --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Popis</label>
                    <textarea id="description" name="description" rows="3"
                              style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; font-family: inherit;">{{ old('description') }}</textarea>
                </div>

                {{-- Upload obrázka --}}
                <div style="margin-bottom: 1rem;">
                    <label for="image" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Obrázok produktu</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <small style="color: #666;">JPG/PNG/WebP, max 2MB (odporúčané: 800×800)</small>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label for="price_cents" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Cena (v centoch) *</label>
                        <input type="number" id="price_cents" name="price_cents" required min="0" value="{{ old('price_cents', 0) }}"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;"
                               placeholder="napr. 599 pre 5.99€">
                        <small style="color: #666;">Napr. 599 = 5,99 €</small>
                    </div>

                    <div>
                        <label for="stock" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Skladom (ks) *</label>
                        <input type="number" id="stock" name="stock" required min="0" value="{{ old('stock', 0) }}"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    </div>
                </div>

                <div style="margin-top: 1.5rem; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                        ✓ Vytvoriť produkt
                    </button>
                </div>
            </form>
        </div>

        <div style="background: #f9f9f9; border-radius: 8px; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #333; color: white;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Obrázok</th>
                    <th style="padding: 1rem; text-align: left;">Produkt</th>
                    <th style="padding: 1rem; text-align: left;">Kategória</th>
                    <th style="padding: 1rem; text-align: right;">Cena</th>
                    <th style="padding: 1rem; text-align: center;">Skladom</th>
                    <th style="padding: 1rem; text-align: center;">Aktívny</th>
                    <th style="padding: 1rem; text-align: center;">Akcie</th>
                </tr>
                </thead>

                <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom: 1px solid #ddd; {{ !$product->is_active ? 'opacity: 0.5;' : '' }}">

                        {{-- Náhľad + rýchla zmena obrázka --}}
                        <td style="padding: 0.75rem; width: 190px;">
                            <div style="display:flex; gap: 0.75rem; align-items:center;">
                                <div style="width: 60px; height: 60px; background:#eee; border-radius: 8px; overflow:hidden; flex: 0 0 auto;">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/'.$product->image_path) }}"
                                             alt="{{ $product->name }}"
                                             style="width:100%; height:100%; object-fit:cover;">
                                    @endif
                                </div>

                                <form method="POST"
                                      action="{{ route('admin.products.update', $product) }}"
                                      enctype="multipart/form-data"
                                      style="display:flex; flex-direction:column; gap:0.35rem;">
                                    @csrf
                                    <input type="file" name="image" accept="image/*" style="width: 110px; font-size: 12px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Uložiť</button>
                                </form>
                            </div>
                        </td>

                        <td style="padding: 1rem;">
                            <strong>{{ $product->name }}</strong>
                        </td>

                        <td style="padding: 1rem;">
                            {{ $product->category?->name ?? '-' }}
                        </td>

                        <td style="padding: 1rem; text-align: right;">
                            <strong>{{ number_format($product->price_cents / 100, 2) }} €</strong>
                        </td>

                        {{-- ✅ STOCK ide na update route --}}
                        <td style="padding: 1rem; text-align: center;">
                            <form method="POST" action="{{ route('admin.products.update', $product) }}" style="display: inline;">
                                @csrf
                                <input type="number" name="stock" value="{{ $product->stock }}"
                                       style="width: 60px; padding: 0.25rem; text-align: center; border: 1px solid #ddd; border-radius: 4px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary" style="margin-left: 0.5rem;">✓</button>
                            </form>
                        </td>

                        <td style="padding: 1rem; text-align: center;">
                            <form method="POST" action="{{ route('admin.products.toggle', $product) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-outline-secondary' }}">
                                    {{ $product->is_active ? '✓ Aktívny' : '✗ Neaktívny' }}
                                </button>
                            </form>
                        </td>

                        <td style="padding: 1rem; text-align: center;">
                            <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                👁️ Zobraziť
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 2rem; text-align: center; color: #999;">
                            Žiadne produkty
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem; padding: 1rem; background: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 4px;">
            <strong>💡 Tip:</strong> Nahraj obrázok pri produkte cez „Uložiť“. Zmeň skladové množstvo a klikni ✓ pre uloženie.
        </div>
    </div>
@endsection
