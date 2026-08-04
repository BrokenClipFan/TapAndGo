<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request) {

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|numeric',
            'price'       => 'required|numeric',
            'quantity'    => 'required|numeric',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp,avif',
        ]);

        $validated['image_path'] = $request->file('image')->store('products', 'public');
        $validated['stock'] = $request->quantity;

        Product::create($validated);    

        return redirect()->route('admin.dashboard')->with('success', 'A new product has been created');
    }

    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'category_id' => 'nullable|numeric',
            'name'        => 'nullable|string|max:255',
            'price'       => 'nullable|numeric',
            'quantity'    => 'nullable|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp,avif',
        ]);

        $imagePath = $product->image_path;
        $validated['stock'] = $request->quantity;

        if($validated['stock'] > 0 && $product->status == 'out of stock' && $product->status != 'unavailable') {
            $validated['status'] = 'available';
        }

        if($validated['stock'] == 0 && $product->status != 'unavailable') {
            $validated['status'] = 'out of stock';
        }

        if($request->hasFile('image')) {
            if($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $dataToUpdate = array_filter($validated, fn($value) => !is_null($value));

        $product->update($dataToUpdate);

        return back()->with('success', 'Product has been updated successfully');
    }

    public function destroy(Product $product) {
        
        $product->update([
            'visible' => false
        ]);

        return back()->with('success', 'The product has been deleted successfully');
    }

    public function restock(Request $request, Product $product) {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product->stock = $product->stock + $request->quantity;
        $product->save();

        return back()->with('success', $product->name . " has been restocked!");
    }
}
