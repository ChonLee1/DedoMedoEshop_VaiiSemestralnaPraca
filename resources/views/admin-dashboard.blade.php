@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-page">

    <div class="admin-header">
        <h1>⚙️ Admin Dashboard</h1>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn--primary">Odhlásiť sa</button>
        </form>
    </div>

    {{-- ŠTATISTIKY --}}
    <div class="admin-stats">
        <div class="admin-stat admin-stat--products">
            <h3>{{ $totalProducts }}</h3>
            <p>📦 Produktov</p>
        </div>

        <div class="admin-stat admin-stat--categories">
            <h3>{{ $totalCategories }}</h3>
            <p>🏷️ Kategórií</p>
        </div>

        <div class="admin-stat admin-stat--orders">
            <h3>{{ $totalOrders }}</h3>
            <p>📋 Objednávok</p>
        </div>

        <div class="admin-stat admin-stat--revenue">
            <h3>{{ number_format($totalRevenue, 0) }} €</h3>
            <p>💰 Tržby</p>
        </div>
    </div>

    {{-- RÝCHLE AKCIE --}}
    <div class="admin-actions">
        <h2>🚀 Rýchle akcie</h2>

        <div class="admin-actions__grid">
            <a href="{{ route('admin.products') }}" class="btn btn--primary admin-action">
                📦 Spravovať produkty
            </a>
            <a href="{{ route('admin.categories') }}" class="btn btn--primary admin-action">
                🏷️ Spravovať kategórie
            </a>
        </div>
    </div>

</div>
@endsection
