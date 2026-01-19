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

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Názov produktu *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                    </div>

                    <div>
                        <label for="category_id" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Kategória *</label>
                        <select id="category_id" name="category_id" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                            <option value="">-- Vyber --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Popis</label>
                    <textarea id="description" name="description" rows="2"
                              style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; font-family: inherit; box-sizing: border-box;">{{ old('description') }}</textarea>
                </div>

                {{-- Upload obrázka --}}
                <div style="margin-bottom: 1.5rem;">
                    <label for="image" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Obrázok produktu</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                    <small style="color: #666; display: block; margin-top: 0.3rem;">JPG/PNG/WebP, max 2MB (odporúčané: 800×800)</small>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="price_cents" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Cena (v centoch) *</label>
                        <input type="number" id="price_cents" name="price_cents" required min="0" value="{{ old('price_cents', 0) }}"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                               placeholder="napr. 599 pre 5.99€">
                        <small style="color: #666; display: block; margin-top: 0.3rem;">Napr. 599 = 5,99 €</small>
                    </div>

                    <div>
                        <label for="stock" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Skladom (ks) *</label>
                        <input type="number" id="stock" name="stock" required min="0" value="{{ old('stock', 0) }}"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem; font-size: 1rem; font-weight: bold;">
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

                        {{-- Náhľad obrázka --}}
                        <td style="padding: 0.75rem; text-align: center;">
                            <div style="width: 60px; height: 60px; background:#eee; border-radius: 8px; overflow:hidden; margin: 0 auto;">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/'.$product->image_path) }}"
                                         alt="{{ $product->name }}"
                                         style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #999;">📦</div>
                                @endif
                            </div>
                        </td>

                        <td style="padding: 1rem;">
                            <strong>{{ $product->name }}</strong>
                        </td>

                        <td style="padding: 1rem;">
                            {{ $product->category?->name ?? '-' }}
                        </td>

                        <td style="padding: 1rem; text-align: right;">
                            <strong>{{ number_format($product->price_cents / 100, 2, ',', ' ') }} €</strong>
                        </td>

                        {{-- Skladom --}}
                        <td style="padding: 1rem; text-align: center;">
                            <strong>{{ $product->stock }} ks</strong>
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
                            <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal({{ $product->id }}, '{{ str_replace("'", "\\'", $product->name) }}', {{ $product->category_id ?? 'null' }}, {{ $product->price_cents }}, {{ $product->stock }})">
                                ✏️ Upraviť
                            </button>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Naozaj chceš zmazať tento produkt?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    🗑️ Zmazať
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding: 2rem; text-align: center; color: #999;">
                            Žiadne produkty
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem; padding: 1rem; background: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 4px;">
            <strong>💡 Tip:</strong> Klikni na "Upraviť" na úpravu produktu. Obrázok nahraj vedľa položky.
        </div>
    </div>

    {{-- MODAL na úpravu produktu --}}
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 99999; justify-content: center; align-items: center;">
        <div style="background: white; border-radius: 8px; padding: 2rem; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="margin: 0;">✏️ Upraviť produkt</h2>
                <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">✕</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div style="margin-bottom: 1.5rem;">
                    <label for="edit_name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Názov produktu *</label>
                    <input type="text" id="edit_name" name="name" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="edit_category_id" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Kategória *</label>
                        <select id="edit_category_id" name="category_id" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                            <option value="">-- Vyber --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="edit_price_cents" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Cena (v centoch) *</label>
                        <input type="number" id="edit_price_cents" name="price_cents" required min="0"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                        <small id="priceDisplay" style="color: #666; display: block; margin-top: 0.3rem;"></small>
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="edit_stock" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Skladom (ks) *</label>
                    <input type="number" id="edit_stock" name="stock" required min="0"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="edit_image" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Obrázok produktu</label>
                    <input type="file" id="edit_image" name="image" accept="image/*"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                    <small style="color: #666; display: block; margin-top: 0.3rem;">JPG/PNG/WebP, max 2MB (odporúčané: 800×800)</small>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.75rem;">
                        ✓ Uložiť zmeny
                    </button>
                    <button type="button" onclick="closeEditModal()" class="btn btn-outline-secondary" style="flex: 1; padding: 0.75rem;">
                        Zrušiť
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(productId, name, categoryId, priceCents, stock) {
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_category_id').value = categoryId || '';
            document.getElementById('edit_price_cents').value = priceCents;
            document.getElementById('edit_stock').value = stock;

            // Aktualizuj cenu v EUR
            updatePriceDisplay(priceCents);

            // Nastav action na správny route
            const form = document.getElementById('editForm');
            form.action = '/admin/products/' + productId + '/update';

            // Zobraz modal
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function updatePriceDisplay(cents) {
            const eur = (cents / 100).toLocaleString('sk-SK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            document.getElementById('priceDisplay').textContent = eur + ' €';
        }

        // Update price display keď user zadá cenu
        document.getElementById('edit_price_cents').addEventListener('input', function() {
            updatePriceDisplay(this.value);
        });

        // Zatvri modal keď klikneš mimo formulára
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
