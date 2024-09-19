<?php

use App\Http\Controllers\Checkout\PayPalController;
use App\Http\Controllers\Checkout\StripeController;
use Illuminate\Support\Facades\Route;

Route::prefix('checkout')->group(function () {
    //paypal
    Route::get('paypal', [PayPalController::class, 'checkout'])->name('checkout.paypal');
    Route::get('paypal/success', [PayPalController::class, 'success'])->name('checkout.paypal.success');

    Route::get('paypal/cancel', function () {
        return 'Payment canceled';
    })->name('checkout.paypal.cancel');
    

    //stripe
    Route::get('stripe', [StripeController::class, 'checkout'])->name('checkout.stripe');
    Route::get('stripe/success', [StripeController::class, 'success'])->name('checkout.stripe.success');

    Route::get('stripe/cancel', function () {
        return 'Payment canceled';
    })->name('checkout.stripe.cancel');
});
