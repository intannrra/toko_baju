<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    PesananController,
    DashboardController,
    TransController,
    CheckoutController,
    AuthController,
    TransactionController,
    ProfilController,
};
use App\Http\Middleware\RoleMiddleware;

// Route untuk halaman home
Route::get('/', [HomeController::class, 'index'])->name('homes.home');

// Route untuk autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.process');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

// Route untuk resource controllers
Route::resource('/products', ProductController::class);
Route::resource('/pesanans', PesananController::class);
Route::resource('/trans', TransactionController::class);

// Route untuk halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process'); // Memproses checkout
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('trans.checkout');
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm']);
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/checkout', [TransactionController::class, 'checkout'])->name('trans.checkout');
Route::post('/checkout', [TransactionController::class, 'processCheckout']);
Route::post('/checkout', [TransactionController::class, 'Checkout']);


// Route untuk Profil dengan middleware autentikasi
//Route::middleware('auth')->group(function () {
    //Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');
    //Route::put('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');
    //Route::delete('/profil/{id}', [ProfilController::class, 'destroy'])->name('profil.destroy');
    //Route::get('/profil/{id}/edit', [ProfilController::class, 'edit'])->name('profil.edit');
//});

Route::middleware([RoleMiddleware:: class . ':Admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::middleware([RoleMiddleware:: class . ':User'])->group(function () {
    Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');
    Route::put('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil/{id}', [ProfilController::class, 'destroy'])->name('profil.destroy');
    Route::get('/profil/{id}/edit', [ProfilController::class, 'edit'])->name('profil.edit');
});
