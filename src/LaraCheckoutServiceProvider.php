<?php

namespace Hossam\LaraCheckout;

use Hossam\LaraCheckout\Console\MakePayPalController;
use Illuminate\Support\ServiceProvider;

class LaraCheckoutServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/checkout-paypal.php', 'checkout-paypal');
        $this->mergeConfigFrom(__DIR__ . '/config/checkout-stripe.php', 'checkout-stripe');

        $this->commands([
            MakePayPalController::class,
        ]);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->publishes([
            __DIR__ . '/config/checkout-paypal.php' => config_path('checkout-paypal.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/config/checkout-stripe.php' => config_path('checkout-stripe.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/stubs/PayPalController.stub' => app_path('Http/Controllers/Checkout/PayPalController.php'),
            __DIR__ . '/stubs/StripeController.stub' => app_path('Http/Controllers/Checkout/StripeController.php'),
        ], 'controllers');
    }
}
