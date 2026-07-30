<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class CashierController extends Controller
{
    public function view(Request $request) {
        $validated = $request->validate([
            'code' => 'required|string|max:255'
        ]);

        $order = Order::where('order_code', $validated['code'])->with('items.product')->first();

        return view('cashier.index',compact('order'))->with('success', 'Order is found');
    }
}
