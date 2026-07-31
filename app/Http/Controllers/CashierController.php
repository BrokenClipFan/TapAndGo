<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function view(Request $request) {
        $validated = $request->validate([
            'code' => 'required|string|max:255'
        ]);

        $order = Order::where('order_code', $validated['code'])->with('items.product')->first();

        if($order == null) {
            return redirect()->route('cashier')->with('error', 'Order Doesnt Exists');
        }

        if($order->status === 'paid') {
            return redirect()->route('cashier')->with('success', 'This order is already checked out');
        }

        if($order->created_at->isBefore(now()->subDay())) {
            return redirect()->route('cashier')->with('error', 'Order Expired');
        }

        $outOfStockItems = [];
        $unavailableItems = [];
        $invalidItems = [];
        $itemStocks = [];

        foreach($order->items as $item){

            if($item->product->stock === 0) {
                $outOfStockItems[] = $item->id;
                continue;
            }

            if($item->product->status !== 'available') {
                $unavailableItems[] = $item->id;
                continue;
            }

            $itemStocks[$item->id] = $item->product->stock;

            $remainingStock = $item->product->stock - $item->quantity;
            
            if($remainingStock < 0) {
                $invalidItems[] = $item->id;
                continue;
            }
        }
        
        return view('cashier.index',compact('order', 'outOfStockItems', 'unavailableItems', 'invalidItems', 'itemStocks'))->with('success', 'Order is found');
    }

    public function paidOrder(Request $request) {
        $validated = $request->validate([
            'id'                 => 'required|integer|exists:orders,id',
            'items'              => 'required|array|min:1',
            'items.*.id'         => 'required|integer',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.product_id' => 'required|integer'
        ]);

        DB::beginTransaction();
        
        try{
            $order = Order::findOrFail($request->id);

            $order->items()->delete();

            $items = [];
            
            foreach($validated['items'] as $item){

                $product = Product::findOrFail($item['product_id']);

                if($product->status !== 'available') {
                    continue;
                }

                $remainingStock = $product->stock - $item['quantity'];
                
                if($remainingStock < 0) {
                    continue;
                }

                if($remainingStock === 0) {
                    $product->status = 'out of stock';
                }

                $items[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $item['product_id'],
                    'price' => $product->price,
                    'total' => $item['quantity'] * $product->price,
                ];

                $product->stock = $remainingStock;
                $product->save();

            }

            $order->update([
                'status' => 'paid'
            ]);

            $order->items()->delete();
            $order->items()->createMany($items);
            
            DB::commit();

        } catch(\Exception $e) {
            DB::rollBack();

            return redirect()->route('cashier')->with('error', $e->getMessage());
        }

        return redirect()->route('cashier')->with('success', 'Checkout Successfull');
        
    }

    public function cancelledOrder(Request $request) {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $order = Order::findOrFail($request->id);
        $order->delete();

        return redirect()->route('cashier')->with('success', 'Order Cancelled');
    }
}
