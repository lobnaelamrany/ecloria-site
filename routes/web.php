<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// ==========================================
// Public Routes
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/search', [\App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Brands
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{slug}', [BrandController::class, 'show'])->name('brands.show');

// ==========================================
// Auth Routes (Guest only)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ==========================================
// Logout (Authenticated only)
// ==========================================
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ==========================================
// Authenticated Client Routes
// ==========================================
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product:slug}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::patch('/profile/addresses/{address}', [ProfileController::class, 'updateAddress'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{address}', [ProfileController::class, 'destroyAddress'])->name('profile.addresses.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Returns (Client)
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('/orders/{order}/return', [ReturnController::class, 'create'])->name('returns.create');
    Route::post('/orders/{order}/return', [ReturnController::class, 'store'])->name('returns.store');

    // Reviews (Client)
    Route::post('/reviews/{orderItem}', [ReviewController::class, 'store'])->name('reviews.store');

    // Complaints (Client)
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('client.complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('client.complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('client.complaints.store');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product:slug}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// ==========================================
// Admin Routes (Protected)
// ==========================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin,employee'])
    ->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Catalogue
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);

        // Ventes (Orders)
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::patch('orders/{order}/payment', [\App\Http\Controllers\Admin\OrderController::class, 'updatePayment'])->name('orders.updatePayment');

        // Ventes (Promotions)
        Route::resource('promotions', \App\Http\Controllers\Admin\PromotionController::class);

        // Ventes (Returns)
        Route::get('returns', [\App\Http\Controllers\Admin\ReturnController::class, 'index'])->name('returns.index');
        Route::get('returns/{return}', [\App\Http\Controllers\Admin\ReturnController::class, 'show'])->name('returns.show');
        Route::patch('returns/{return}/status', [\App\Http\Controllers\Admin\ReturnController::class, 'updateStatus'])->name('returns.updateStatus');

        // Stock
        Route::get('stock', [\App\Http\Controllers\Admin\StockController::class, 'index'])->name('stock.index');
        Route::get('stock/batches', [\App\Http\Controllers\Admin\StockController::class, 'batches'])->name('stock.batches');
        Route::get('stock/movements', [\App\Http\Controllers\Admin\StockController::class, 'movements'])->name('stock.movements');
        Route::resource('suppliers', \App\Http\Controllers\Admin\SupplierController::class);
        Route::resource('purchases', \App\Http\Controllers\Admin\PurchaseController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('purchases/{purchase}/receive', [\App\Http\Controllers\Admin\PurchaseController::class, 'receive'])->name('purchases.receive');
        Route::patch('purchases/{purchase}/cancel', [\App\Http\Controllers\Admin\PurchaseController::class, 'cancel'])->name('purchases.cancel');

        // Clients & Service (Clients)
        Route::get('clients', [\App\Http\Controllers\Admin\UserController::class, 'clients'])->name('users.clients');
        Route::patch('clients/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggleClient'])->name('users.clients.toggle');

        // Clients & Service (Employees)
        Route::get('employees', [\App\Http\Controllers\Admin\UserController::class, 'employees'])->name('users.employees');
        Route::get('employees/create', [\App\Http\Controllers\Admin\UserController::class, 'createEmployee'])->name('users.employees.create');
        Route::post('employees', [\App\Http\Controllers\Admin\UserController::class, 'storeEmployee'])->name('users.employees.store');
        Route::get('employees/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'editEmployee'])->name('users.employees.edit');
        Route::put('employees/{user}', [\App\Http\Controllers\Admin\UserController::class, 'updateEmployee'])->name('users.employees.update');
        Route::delete('employees/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroyEmployee'])->name('users.employees.destroy');

        // Clients & Service (Complaints)
        Route::get('complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('complaints.index');
        Route::get('complaints/{complaint}', [\App\Http\Controllers\Admin\ComplaintController::class, 'show'])->name('complaints.show');
        Route::patch('complaints/{complaint}/status', [\App\Http\Controllers\Admin\ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
    });

// ==========================================
// Language Switcher
// ==========================================
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en', 'de'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
