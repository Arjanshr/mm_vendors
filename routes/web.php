<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'ensure-user-active',
    'ensure-user-vendor'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    //Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders')->middleware('can:browse-orders');
    Route::middleware('can:add-orders')->group(function () {
        Route::get('/orders/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/orders/insert', [OrderController::class, 'insert'])->name('order.insert');
    });
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show')->middleware('can:read-orders');
    Route::middleware('can:edit-orders')->group(function () {
        Route::get('/orders/edit/{order}', [OrderController::class, 'edit'])->name('order.edit');
        Route::patch('/orders/edit/{order}', [OrderController::class, 'update'])->name('order.update');
    });
    Route::delete('/orders/delete/{order}', [OrderController::class, 'delete'])->name('order.delete')->middleware('can:delete-orders');
    
    //Products routes
    Route::get('products/export', [ProductController::class, 'export'])->name('product.export');
    Route::get('/products', [ProductController::class, 'index'])->name('products')->middleware('can:browse-products');
    Route::middleware('can:add-products')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/products/insert', [ProductController::class, 'insert'])->name('product.insert');
    });

    Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.show')->middleware('can:read-products');
    Route::middleware('can:edit-products')->group(function () {
        Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
        Route::patch('/products/edit/{product}', [ProductController::class, 'update'])->name('product.update');

        Route::get('/products/specifications/{product}', [ProductController::class, 'manageSpecifications'])->name('product.specifications');
        Route::get('/products/specifications/create/{product}', [ProductController::class, 'createSpecifications'])->name('product.specification.create');
        Route::post('/products/specifications/insert/{product}', [ProductController::class, 'insertSpecifications'])->name('product.specification.insert');
        Route::get('/products/specifications/edit/{product_specification}', [ProductController::class, 'editSpecifications'])->name('product.specification.edit');
        Route::patch('/products/specifications/edit/{product_specification}', [ProductController::class, 'updateSpecifications'])->name('product.specification.update');
        Route::delete('/products/specifications/delete/{product}/{specification}', [ProductController::class, 'deleteSpecifications'])->name('product.specification.delete');
        Route::delete('/products/specifications/delete_all/{product}', [ProductController::class, 'deleteAllSpecifications'])->name('product.specification.delete.all');

        Route::get('/products/features/{product}', [ProductController::class, 'manageFeatures'])->name('product.features');
        Route::get('/products/features/create/{product}', [ProductController::class, 'createFeatures'])->name('product.feature.create');
        Route::post('/products/features/insert/{product}', [ProductController::class, 'insertFeatures'])->name('product.feature.insert');
        Route::get('/products/features/edit/{feature}', [ProductController::class, 'editFeatures'])->name('product.feature.edit');
        Route::patch('/products/features/edit/{feature}', [ProductController::class, 'updateFeatures'])->name('product.feature.update');
        Route::delete('/products/features/delete/{feature}', [ProductController::class, 'deleteFeatures'])->name('product.feature.delete');
        Route::delete('/products/features/delete_all/{product}', [ProductController::class, 'deleteAllFeatures'])->name('product.features.delete.all');

        Route::get('/products/images/link-images', [ProductController::class, 'linkImages']);
        Route::get('/products/images/{product}', [ProductController::class, 'manageImages'])->name('product.images');
        Route::post('/products/images/insert/{product}', [ProductController::class, 'insertImages'])->name('product.image.insert');
        Route::patch('/products/images/edit/{product}', [ProductController::class, 'updateImages'])->name('product.image.update');
        Route::delete('/products/images/delete/{product}', [ProductController::class, 'deleteImages'])->name('product.image.delete');

        Route::get('/products/variants/{product}', [ProductController::class, 'manageVariants'])->name('product.variants');
        Route::get('/products/variants/create/{product}', [ProductController::class, 'createVariants'])->name('product.variant.create');
        Route::post('/products/variants/insert/{product}', [ProductController::class, 'insertVariants'])->name('product.variant.insert');
        // Edit Variant
        Route::get('/products/{product}/variants/{variant}/edit', [ProductController::class, 'editVariants'])->name('product.variant.edit');

        // Update Variant
        Route::put('/products/{product}/variants/{variant}', [ProductController::class, 'updateVariants'])->name('product.variant.update');

        // Delete Variant
        Route::delete('/products/{product}/variants/{variant}', [ProductController::class, 'deleteVariants'])->name('product.variant.delete');
        Route::delete('/products/variants/delete_all/{product}', [ProductController::class, 'deleteAllVariants'])->name('product.variant.delete.all');
    });
    Route::delete('/products/delete/{product}', [ProductController::class, 'delete'])->name('product.delete')->middleware('can:delete-products');
});
