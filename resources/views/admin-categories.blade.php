@extends('layouts.app')
@section('title', 'Správa kategórií')
@section('content')
<div class="container" style="margin: 3rem auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>📂 Správa kategórií</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Späť</a>
    </div>

    @if(session('success'))
        <div style="background: #e8f5e9; border: 1px solid #4caf50; color: #2e7d32; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Formulár na pridanie novej kategórie --}}
    <div style="background: #f0f7ff; border: 2px solid #2196f3; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="margin-top: 0;">➕ Pridať novú kategóriu</h3>
        <form method="POST" action="{{ route('admin.categories.create') }}" style="display: flex; gap: 1rem; align-items: flex-end;">
            @csrf
            <div style="flex: 1;">
                <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Názov kategórie:</label>
                <input type="text" id="name" name="name" required
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('name')
                    <small style="color: #d32f2f;">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                ✓ Vytvoriť
            </button>
        </form>
    </div>

    {{-- Zoznam kategórií --}}
    <div style="background: #f9f9f9; border-radius: 8px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #333; color: white;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Názov</th>
                    <th style="padding: 1rem; text-align: left;">Slug</th>
                    <th style="padding: 1rem; text-align: center;">Počet produktov</th>
                    <th style="padding: 1rem; text-align: center;">Aktívna</th>
                    <th style="padding: 1rem; text-align: center;">Vytvorená</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr style="border-bottom: 1px solid #ddd; {{ !$category->is_active ? 'opacity: 0.5;' : '' }}">
                        <td style="padding: 1rem;">
                            <strong style="font-size: 1.1rem;">{{ $category->name }}</strong>
                        </td>
                        <td style="padding: 1rem; color: #666; font-family: monospace;">
                            {{ $category->slug }}
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <span style="background: #e3f2fd; padding: 0.25rem 0.75rem; border-radius: 12px; font-weight: bold;">
                                {{ $category->products_count }} produktov
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <form method="POST" action="{{ route('admin.categories.toggle', $category) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-success' : 'btn-outline-secondary' }}">
                                    {{ $category->is_active ? '✓ Aktívna' : '✗ Neaktívna' }}
                                </button>
                            </form>
                        </td>
                        <td style="padding: 1rem; text-align: center; color: #666; font-size: 0.9rem;">
                            {{ $category->created_at->format('d.m.Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #999;">
                            Žiadne kategórie
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem; padding: 1rem; background: #fff3e0; border-left: 4px solid #ff9800; border-radius: 4px;">
        <strong>💡 Tip:</strong> Klikni na "✓ Aktívna" pre deaktiváciu kategórie. Slug sa vytvorí automaticky z názvu.
    </div>
</div>
@endsection

