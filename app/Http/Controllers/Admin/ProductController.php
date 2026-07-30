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

        if($request->hasFile('image')) {
            if($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $dataToUpdate = array_filter($validated, fn($value) => !is_null($value));

        $product->update($dataToUpdate);

        return redirect()->route('admin.dashboard')->with('success', 'Product has been updated successfully');
    }

    public function destroy(Product $product) {
        if($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'The product has been deleted successfully');
    }
}
