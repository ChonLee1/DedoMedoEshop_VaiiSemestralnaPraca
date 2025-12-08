@extends('layouts.app')

@section('title', 'Pridať kategóriu')

@section('content')
    <div class="container py-4">
        {{-- Návrat na index kategórií --}}
        <div class="mb-4">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Späť na zoznam</a>
        </div>

        {{-- Nadpis stránky --}}
        <h1 class="mb-4">Pridať novú kategóriu</h1>

        <div class="card">
            <div class="card-body">
                {{-- Formulár pre vytvorenie kategórie --}}
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf {{-- ochrana proti CSRF útoku --}}

                    {{-- Názov kategórie (povinné pole) --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Názov kategórie *</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                        >
                        {{-- Chybová hláška k poľu name --}}
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Slug (URL identifikátor, povinné) --}}
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug (URL) *</label>
                        <input
                            type="text"
                            class="form-control @error('slug') is-invalid @enderror"
                            id="slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            required
                            placeholder="napr: med-z-luk"
                            {{-- TIP: môžeš pridať pattern na klientsku validáciu, napr.:
                            pattern="^[a-z0-9]+(?:-[a-z0-9]+)*$" title="Len malé písmená, čísla a pomlčky" --}}
                        >
                        <small class="text-muted">Používajte len malé písmená, čísla a pomlčky</small>
                        {{-- Chybová hláška k poľu slug --}}
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nepovinný popis kategórie --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Popis</label>
                        <textarea
                            class="form-control @error('description') is-invalid @enderror"
                            id="description"
                            name="description"
                            rows="3"
                        >{{ old('description') }}</textarea>
                        {{-- Chybová hláška k poľu description --}}
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Prepínač aktivity kategórie (či sa zobrazí na webe) --}}
                    <div class="mb-3 form-check">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            Aktívna (zobrazená na webe)
                        </label>
                    </div>

                    {{-- Odoslanie formulára --}}
                    <button type="submit" class="btn btn-primary">Vytvoriť kategóriu</button>
                </form>
            </div>
        </div>
    </div>
@endsection
