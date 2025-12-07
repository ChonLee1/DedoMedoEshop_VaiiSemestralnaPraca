@extends('layouts.app')

@section('title', 'Upraviť kategóriu')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Späť na zoznam</a>
    </div>

    <h1 class="mb-4">Upraviť kategóriu: {{ $category->name }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Názov kategórie *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug (URL) *</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                           id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required
                           placeholder="napr: med-z-luk">
                    <small class="text-muted">Používajte len malé písmená, čísla a pomlčky</small>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Popis</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active"
                           name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Aktívna (zobrazená na webe)
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
            </form>
        </div>
    </div>
</div>
@endsection

