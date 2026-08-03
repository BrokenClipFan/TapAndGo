<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CashierController;



Route::get('/', [CostumerController::class, 'index'])->name('costumer');
Route::post('/order/store', [CostumerController::class, 'store']);
Route::get('/ticket/{order}', TicketController::class)->name('ticket');



Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::put('/admin/category/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{category}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::put('/admin/product/update/{product}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::put('/admin/product/restock/{product}', [ProductController::class, 'restock'])->name('admin.product.restock');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cashier', function () {
        return view('cashier.index');
    })->name('cashier');

    Route::post('/cashier/order', [CashierController::class, 'view'])->name('cashier.order');
    Route::put('/cashier/order/pay', [CashierController::class, 'paidOrder'])->name('cashier.order.pay');
    Route::delete('/cashier/order/cancel', [CashierController::class, 'cancelledOrder'])->name('cashier.order.cancel');
});



require __DIR__.'/auth.php';