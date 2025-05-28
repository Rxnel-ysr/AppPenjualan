<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/sales', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/sales/add', [SaleController::class, 'create'])->name('sale.create');
    Route::post('/sales', [SaleController::class, 'addSale'])->name('sale.store');
    Route::delete('/sales/delete', [SaleController::class, 'deleteSale'])->name('sale.delete');
    Route::put('/sales/update', [SaleController::class, 'updateSale'])->name('sale.update');

    Route::get('/items', [ItemController::class, 'index'])->name('item.index');
    Route::post('/items/add', [ItemController::class, 'addItem'])->name('item.store');
    Route::delete('/items/delete', [ItemController::class, 'deleteItem'])->name('item.delete');
    Route::put('/items/update', [ItemController::class, 'updateItem'])->name('item.update');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/suppliers/add', [SupplierController::class, 'addSupplier'])->name('supplier.store');
    Route::delete('/suppliers/delete', [SupplierController::class, 'deleteSupplier'])->name('supplier.delete');
    Route::put('/suppliers/update', [SupplierController::class, 'updateSupplier'])->name('supplier.update');

    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/categories/add', [CategoryController::class, 'addCategory'])->name('category.store');
    Route::delete('/categories/delete', [CategoryController::class, 'deleteCategory'])->name('category.delete');
    Route::put('/categories/update', [CategoryController::class, 'updateCategory'])->name('category.update');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customers/add', [CustomerController::class, 'addCustomer'])->name('customer.store');
    Route::delete('/customers/delete', [CustomerController::class, 'deleteCustomer'])->name('customer.delete');
    Route::put('/customers/update', [CustomerController::class, 'updateCustomer'])->name('customer.update');

    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('/purchases/add', [PurchaseController::class, 'addPurchase'])->name('purchase.store');
    Route::delete('/purchases/delete', [PurchaseController::class, 'deletePurchase'])->name('purchase.delete');
    Route::put('/purchases/update', [PurchaseController::class, 'updatePurchase'])->name('purchase.update');

    Route::post('/sale/report', [SaleController::class, 'generateSaleReport'])->name('sale.pdf');
});

Route::get('/test/{id}', [TestController::class, 'generateSaleReport']);

require __DIR__ . '/auth.php';
