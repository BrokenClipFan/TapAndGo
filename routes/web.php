<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
        return view('costumers');
});

Route::get('/cashier', function () {
        return view('cashier.index');
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
Route::put('/admin/category/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
Route::delete('/admin/category/delete/{category}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.product.store');
Route::put('/admin/product/update/{product}', [ProductController::class, 'update'])->name('admin.product.update');
Route::delete('/admin/product/delete/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

Route::middleware(['auth', 'check.admin'])->group(function () {
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__.'/auth.php';
