<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Collection;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = 0;
        $activeProducts = 0;
        $totalCategories = 0;
        $totalOrders = 0;
        $totalRevenue = 0;

        try {
            $totalProducts = Product::count();
            $activeProducts = Product::where('is_active', true)->count();
            $totalCategories = Category::count();
            $totalOrders = Order::count();

            if ($totalOrders > 0) {
                $totalRevenue = (Order::sum('total_cents') ?? 0) / 100;
            }
        } catch (\Exception $e) {
            \Log::error('Admin Dashboard Error: ' . $e->getMessage());
        }

        return view('admin-dashboard', compact(
            'totalProducts',
            'activeProducts',
            'totalCategories',
            'totalOrders',
            'totalRevenue'
        ));
    }

    public function stats()
    {
        try {
            $stats = [
                'total_products' => Product::count(),
                'active_products' => Product::where('is_active', true)->count(),
                'total_categories' => Category::count(),
                'total_orders' => Order::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'total_revenue' => round((Order::sum('total_cents') ?? 0) / 100, 2),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Chyba pri načítaní štatistík'
            ], 500);
        }
    }
}
