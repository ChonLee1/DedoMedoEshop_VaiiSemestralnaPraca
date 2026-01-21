<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * GET /admin/orders
     * Zoznam všetkých objednávok
     */
    public function index()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * GET /admin/orders/{order}
     * Detaily objednávky
     */
    public function show(Order $order)
    {
        $order->load('orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * GET /checkout
     * Zobrazenie checkout stránky
     */
    public function checkout()
    {
        return view('checkout');
    }

    /**
     * POST /orders
     * Vytvor novú objednávku z košíka
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'cart_items' => 'required|json',
        ]);

        try {
            // Parsuj cart items z JSON
            $cartItems = json_decode($validated['cart_items'], true);

            if (empty($cartItems)) {
                return back()->withErrors(['cart' => 'Košík je prázdny']);
            }

            // Vypočítaj celkovú sumu
            $totalCents = 0;
            foreach ($cartItems as $item) {
                $totalCents += $item['price'] * $item['quantity'] * 100; // konverzia na centy
            }

            // Vytvor objednávku
            $order = Order::create([
                'code' => 'ORD-' . time() . '-' . rand(1000, 9999),
                'status' => 'pending',
                'total_cents' => (int) $totalCents,
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            // Vytvor OrderItems
            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['quantity'],
                    'unit_price_cents' => (int) ($item['price'] * 100), // ceny v centoch
                ]);

                // Zníženie skladu po objednávke
                $product->decrement('stock', $item['quantity']);
            }

            // Vrátenie s úspechom
            return redirect()->back()
                ->with('success', 'Objednávka bola úspešne vytvorená! Kód: ' . $order->code)
                ->with('order', $order);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Chyba pri spracovaní objednávky: ' . $e->getMessage()]);
        }
    }


    /**
     * PATCH /admin/orders/{order}
     * Zmena stavu objednávky
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order); // Admin check

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Stav objednávky bol zmenený na: ' . Order::statuses()[$validated['status']]);
    }

    /**
     * DELETE /admin/orders/{order}
     * Zmazať objednávku
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order); // Admin check

        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Objednávka bola zmazaná');
    }
}
