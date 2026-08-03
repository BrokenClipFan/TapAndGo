<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store('categories', 'public');

        Category::create([
            'name' => $validated['name'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Category Added!');
    }

    public function update(Request $request, Category $category) {

        $request->validate([
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048'
        ]);

        $name = $category->name;
        $imagePath = $category->image_path;

        if($request->name){
            $name = $request->name;
        }

        if($request->hasFile('image')) {

            if($imagePath && Storage::disk('public')->exists($imagePath)){
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name' => $name,
            'image_path' => $imagePath
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Category Successfully Updated');
    }
    
    public function destroy(Category $category) {
        
        if($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Category Successfully Deleted');
    }

}
