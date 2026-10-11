<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('products.index');
});


/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
|
| Hanya user yang belum login.
|
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login');


    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.process');


    Route::get(
        '/register',
        [AuthController::class, 'showRegister']
    )->name('register');


    Route::post(
        '/register',
        [AuthController::class, 'register']
    )->name('register.process');
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| PUBLIC PRODUCTS
|--------------------------------------------------------------------------
|
| Collection dapat dilihat tanpa login.
|
*/

Route::get(
    '/products',
    [ProductController::class, 'index']
)->name('products.index');


Route::get(
    '/products/{product}',
    [ProductController::class, 'show']
)->name('products.show');


/*
|--------------------------------------------------------------------------
| CUSTOMER AREA
|--------------------------------------------------------------------------
|
| Harus login DAN memiliki role customer.
|
*/

Route::middleware([
    'auth',
    'customer',
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | MY ORDERS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/my-orders',
        [CheckoutController::class, 'myOrders']
    )->name('orders.my');


    Route::get(
        '/my-orders/{order}',
        [CheckoutController::class, 'showOrder']
    )->name('orders.show');


    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/cart',
        [CartController::class, 'index']
    )->name('cart.index');


    Route::post(
        '/cart/add/{product}',
        [CartController::class, 'add']
    )->name('cart.add');


    Route::put(
        '/cart/{id}',
        [CartController::class, 'update']
    )->name('cart.update');


    Route::delete(
        '/cart/{id}',
        [CartController::class, 'remove']
    )->name('cart.remove');


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/checkout/select',
        [CheckoutController::class, 'select']
    )->name('checkout.select');


    Route::get(
        '/checkout',
        [CheckoutController::class, 'index']
    )->name('checkout.index');


    Route::post(
        '/checkout',
        [CheckoutController::class, 'store']
    )->name('checkout.store');


    Route::get(
        '/checkout/success/{order}',
        [CheckoutController::class, 'success']
    )->name('checkout.success');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
|
| Harus login DAN memiliki role admin.
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware([
        'auth',
        'admin',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | PRODUCT TRASH
        |--------------------------------------------------------------------------
        |
        | Route Trash diletakkan sebelum resource
        | supaya /products/trash tidak dianggap
        | sebagai parameter product.
        |
        */

        Route::get(
            '/products/trash',
            [AdminProductController::class, 'trash']
        )->name('products.trash');


        Route::patch(
            '/products/{id}/restore',
            [AdminProductController::class, 'restore']
        )->name('products.restore');


        Route::delete(
            '/products/{id}/force-delete',
            [AdminProductController::class, 'forceDelete']
        )->name('products.forceDelete');


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'products',
            AdminProductController::class
        )->except('show');


        /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders',
            [AdminOrderController::class, 'index']
        )->name('orders.index');


        Route::get(
            '/orders/{order}',
            [AdminOrderController::class, 'show']
        )->name('orders.show');


        Route::put(
            '/orders/{order}/status',
            [AdminOrderController::class, 'updateStatus']
        )->name('orders.updateStatus');
        Route::put(
    '/orders/{order}/payment-status',
    [AdminOrderController::class, 'updatePaymentStatus']
)->name('orders.updatePaymentStatus');
    });