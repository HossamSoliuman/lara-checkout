<?php

namespace Hossam\LaraCheckout\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('checkout-stripe.stripe_secret'));
    }

    public function createCheckout($products)
    {
        $lineItems = [];
        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product['name'],
                    ],
                    'unit_amount' => $product['price'] * 100, // Convert to cents
                ],
                'quantity' => $product['quantity'],
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('checkout.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.stripe.cancel'),
        ]);

        return $session->url;
    }

    public function verifyPayment($sessionId)
    {
        $session = StripeSession::retrieve($sessionId);
        return $session->payment_status === 'paid';
    }
}
