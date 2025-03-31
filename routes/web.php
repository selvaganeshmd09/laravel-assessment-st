<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// PRODUCT LIST
Route::get('/', [ProductController::class, 'index'])->name('products.list');

Route::middleware('auth')->group(function () {
    Route::get('/shop/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/shop/{product}/pay', [PaymentController::class, 'processPayment'])->name('product.pay');
    Route::get('/payment/status/{paymentId}', [PaymentController::class, 'getPaymentStatus'])->name('payment.status');


    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.error');

});
Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook']);
