<?php

use App\Http\Controllers\Checkout\PayPalController;
use Illuminate\Support\Facades\Route;

Route::prefix('checkout')->group(function () {
    Route::get('paypal', [PayPalController::class, 'checkout'])->name('checkout.paypal');
    Route::get('paypal/success', [PayPalController::class, 'success'])->name('checkout.paypal.success');

    Route::get('paypal/cancel', function () {
        return 'Payment canceled';
    })->name('checkout.paypal.cancel');
});
