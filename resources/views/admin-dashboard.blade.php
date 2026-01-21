{{--Pomoc s AI--}}
{{-- AJAX auto-refresh statistik kazdych 30s --}}
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
            <h3 id="stat-total-products">{{ $totalProducts }}</h3>
            <p>📦 Produktov</p>
            <small id="stat-active-products" style="color: #4caf50;">Aktívnych: {{ $activeProducts }}</small>
        </div>

        <div class="admin-stat admin-stat--categories">
            <h3 id="stat-total-categories">{{ $totalCategories }}</h3>
            <p>🏷️ Kategórií</p>
        </div>

        <div class="admin-stat admin-stat--orders">
            <h3 id="stat-total-orders">{{ $totalOrders }}</h3>
            <p>📋 Objednávok</p>
            <small id="stat-pending-orders" style="color: #ff9800;">Čakajúcich: 0</small>
        </div>

        <div class="admin-stat admin-stat--revenue">
            <h3 id="stat-total-revenue">{{ number_format($totalRevenue, 2) }} €</h3>
            <p>💰 Celkové tržby</p>
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

@push('scripts')
<script>
// interval pre auto-refresh, uklada sa aby sa dal zrusit
let statsRefreshInterval = null;

// AJAX volanie na /admin/stats - nacita statistiky z DB
async function loadAdminStats() {
    const refreshBtn = document.getElementById('refresh-stats-btn');

    // disable tlacidlo pocas loadingu
    if (refreshBtn) {
        refreshBtn.disabled = true;
        refreshBtn.textContent = '⏳ Načítavam...';
    }

    try {
        console.log('🔄 Načítavam štatistiky...');

        // fetch na backend - vrati JSON so statistikami
        const response = await fetch('/admin/stats', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || 'Neznáma chyba');
        }

        // aktualizuj DOM s novymi datami
        const stats = result.data;
        document.getElementById('stat-total-products').textContent = stats.total_products;
        document.getElementById('stat-active-products').innerHTML = `Aktívnych: ${stats.active_products}`;
        document.getElementById('stat-total-categories').textContent = stats.total_categories;
        document.getElementById('stat-total-orders').textContent = stats.total_orders;
        document.getElementById('stat-pending-orders').innerHTML = `Čakajúcich: ${stats.pending_orders}`;
        document.getElementById('stat-total-revenue').textContent = stats.total_revenue.toFixed(2) + ' €';

        console.log('✅ Štatistiky načítané');

        // success feedback na tlacidlo
        if (refreshBtn) {
            refreshBtn.textContent = '✅ Obnovené!';
            setTimeout(() => {
                refreshBtn.textContent = '🔄 Obnoviť štatistiky';
                refreshBtn.disabled = false;
            }, 2000);
        }

    } catch (error) {
        console.error('❌ AJAX Error:', error);
        // error feedback
        if (refreshBtn) {
            refreshBtn.textContent = '❌ Chyba';
            setTimeout(() => {
                refreshBtn.textContent = '🔄 Obnoviť štatistiky';
                refreshBtn.disabled = false;
            }, 3000);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 Admin dashboard AJAX init');

    const refreshBtn = document.getElementById('refresh-stats-btn');

    // manual refresh cez tlacidlo (ak existuje)
    if (refreshBtn) {
        refreshBtn.addEventListener('click', loadAdminStats);
    }

    // prvy load po 2s
    setTimeout(() => loadAdminStats(), 2000);

    // auto-refresh kazdych 30s
    statsRefreshInterval = setInterval(() => loadAdminStats(), 30000);
});

// cleanup intervalu pri odchode zo stranky
window.addEventListener('beforeunload', () => {
    if (statsRefreshInterval) {
        clearInterval(statsRefreshInterval);
    }
});
</script>
@endpush
