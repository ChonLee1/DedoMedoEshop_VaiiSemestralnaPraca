<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'cart_items' => 'required|json',
        ]);

        try {
            $cartItems = json_decode($validated['cart_items'], true);

            if (empty($cartItems)) {
                return back()->withErrors(['cart' => 'Košík je prázdny']);
            }

            $totalCents = 0;
            foreach ($cartItems as $item) {
                $totalCents += $item['price'] * $item['quantity'] * 100;
            }

            $order = Order::create([
                'code' => 'ORD-' . time() . '-' . rand(1000, 9999),
                'status' => 'pending',
                'total_cents' => (int) $totalCents,
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['quantity'],
                    'unit_price_cents' => (int) ($item['price'] * 100),
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return redirect()->back()
                ->with('success', 'Objednávka bola úspešne vytvorená! Kód: ' . $order->code)
                ->with('order', $order);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Chyba pri spracovaní objednávky: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Stav objednávky bol zmenený na: ' . Order::statuses()[$validated['status']]);
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Objednávka bola zmazaná');
    }
}
