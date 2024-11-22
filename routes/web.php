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

// Route untuk halaman home
Route::get('/home', [HomeController::class, 'index'])->name('homes.home');

// Route untuk autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.process');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');


// Route untuk resource controllers
Route::resource('products', ProductController::class);
Route::resource('pesanans', PesananController::class);
Route::resource('trans', TransactionController::class);

// Route untuk halaman checkout
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process'); // Memproses checkout
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('trans.checkout');

// Route untuk halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('checkout.process');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

// Route untuk Profil dengan middleware autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');
    Route::put('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil/{id}', [ProfilController::class, 'destroy'])->name('profil.destroy');
    Route::get('/profil/{id}/edit', [ProfilController::class, 'edit'])->name('profil.edit');
});

