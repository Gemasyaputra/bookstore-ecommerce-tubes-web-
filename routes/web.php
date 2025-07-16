<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminOrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public routes untuk customer
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Admin routes dengan middleware
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('books', BookController::class)->except(['index', 'show']);
    Route::resource('categories', CategoryController::class);
    Route::resource('authors', AuthorController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('/orders/{order}/reject', [AdminOrderController::class, 'reject'])->name('orders.reject');
    Route::get('/orders/{order}/download-proof', [AdminOrderController::class, 'downloadProof'])->name('orders.downloadProof');
});

// Checkout routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
});

// Untuk User


// // Untuk Admin
// Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
// Route::patch('/admin/orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('admin.orders.confirm');
// Route::patch('/admin/orders/{order}/reject', [AdminOrderController::class, 'reject'])->name('admin.orders.reject');
// Route::get('/admin/orders/{order}/download-proof', [AdminOrderController::class, 'downloadProof'])
//     ->name('admin.orders.downloadProof');



// wishlist
// Route::middleware('auth')->group(function () {
//     Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
//     Route::post('/wishlist/add/{book}', [WishlistController::class, 'add'])->name('wishlist.add');
//     Route::delete('/wishlist/remove/{book}', [WishlistController::class, 'remove'])->name('wishlist.remove');
// });

Route::middleware(['auth'])->group(function () {

    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{book}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{book}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // Additional routes for the improved layout
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
    Route::get('/wishlist/share', [WishlistController::class, 'share'])->name('wishlist.share');

    // Cart routes (if you don't have them yet)
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/add-all-wishlist', [CartController::class, 'addAllFromWishlist'])->name('cart.add-all-wishlist');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware('auth');
});
