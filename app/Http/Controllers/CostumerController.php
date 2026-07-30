<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
// use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CostumerController extends Controller
{
    public function index() {
        $categories = Category::all();
        $products = Product::with('category')->latest()->get();

        return view('costumers', compact('categories', 'products'));
    }

    private function generateCode() {
        $code = strtoupper(bin2hex(random_bytes(4)));
        $chunks = str_split($code, 4);
        return implode('-', $chunks);
    }

    public function store(Request $request) {
        
        $validated = $request->validate([
            'order_type' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric',
            'items.*.qty' => 'required|numeric|min:1',
        ]);

        $code = $this->generateCode();
        while(Order::where('order_code', $code)->exists()) {
            $code = $this->generateCode();
        }

        $grandTotal = 0;
        $items = [];

        foreach ($validated['items'] as $item) {

            $total = $item['price'] * $item['qty'];
            $grandTotal += $total;

            $items[] = [
                'product_id' => $item['id'],
                'name'       => $item['name'],
                'quantity'   => $item['qty'],
                'price'      => $item['price'],
                'total'      => $total
            ];

        }

        $order = Order::create([
            'order_code'  => $code,
            'total_price' => $grandTotal,
        ]);

        $order->items()->createMany($items);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'ticket_url' => route('ticket', $order->id)
        ]);
    }

}
