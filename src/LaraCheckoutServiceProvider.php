<?php

namespace Hossam\LaraCheckout;

use Hossam\LaraCheckout\Console\MakePayPalController;
use Illuminate\Support\ServiceProvider;

class LaraCheckoutServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/checkout-paypal.php', 'checkout-paypal');

        $this->commands([
            MakePayPalController::class,
        ]);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->publishes([
            __DIR__ . '/config/checkout-paypal.php' => config_path('checkout-paypal.php'),
        ], 'paypal');
    }
}
