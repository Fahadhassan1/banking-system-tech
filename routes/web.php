<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);

Route::middleware(['auth', 'twofactor'])->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //Accounts Routes
    Route::get('/accounts', [AccountController::class, 'index'])->name(name: 'accounts.index');
    Route::get('/accounts/fetch', [DataTableController::class, 'get_saving_accounts'])->name('accounts.get.data');
    Route::get('/dashboard', [AccountController::class, 'create'])->name(name: 'dashboard');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');


    // Transactions Routes
    Route::get('/transfer', [TransactionController::class, 'create'])->name('transfer.create');
    Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transfer.store');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/fetch', [DataTableController::class, 'get_transactions'])->name('transactions.get.data');


});

require __DIR__.'/auth.php';
