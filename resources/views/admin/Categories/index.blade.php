@extends('layouts.app')

@section('title', 'Kategórie')

@section('content')
    <div class="container py-4">
        {{-- Hlavička stránky: názov + CTA tlačidlo --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Kategórie</h1>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Pridať kategóriu</a>
        </div>

        {{-- Flash správa po úspechu (create/update/delete) --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                {{-- Prázdny stav: ak nie sú žiadne kategórie --}}
                @if($categories->isEmpty())
                    <p class="text-muted">Zatiaľ žiadne kategórie.</p>
                @else
                    {{-- Tabuľka so zoznamom kategórií --}}
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Názov</th>
                            <th>Slug</th>
                            <th>Popis</th>
                            <th>Aktívna</th>
                            <th>Akcie</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                {{-- Primárny kľúč --}}
                                <td>{{ $category->id }}</td>

                                {{-- Názov kategórie --}}
                                <td>{{ $category->name }}</td>

                                {{-- Slug zvýraznený ako kód --}}
                                <td><code>{{ $category->slug }}</code></td>

                                {{-- Krátky popis (limit na 50 znakov; pomlčka ak null) --}}
                                <td>{{ Str::limit($category->description ?? '-', 50) }}</td>

                                {{-- Štítok aktivity (Áno/Nie) --}}
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Áno</span>
                                    @else
                                        <span class="badge bg-secondary">Nie</span>
                                    @endif
                                </td>

                                {{-- Akcie: Edit + Delete (DELETE cez form s potvrdením) --}}
                                <td>
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Upraviť</a>

                                    <form
                                        action="{{ route('categories.destroy', $category) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Naozaj zmazať túto kategóriu?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Zmazať</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{-- Paginácia (Laravel paginator links) --}}
                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
