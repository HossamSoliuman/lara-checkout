<?php

namespace Hossam\LaraCheckout\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    protected $paypal;

    public function __construct()
    {
        $this->paypal = new PayPalClient();
        $this->paypal->setApiCredentials(config('checkout-paypal.paypal'));
        $this->paypal->getAccessToken();
    }

    public function createCheckout($products)
    {
        $items = [];
        $total = 0;

        foreach ($products as $product) {
            $items[] = [
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'unit_amount' => [
                    'currency_code' => 'USD',
                    'value' => $product['price']
                ]
            ];
            $total += $product['price'] * $product['quantity'];
        }

        $data = [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('checkout.paypal.success'),
                'cancel_url' => route('checkout.paypal.cancel'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $total,
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'USD',
                                'value' => $total
                            ]
                        ]
                    ],
                    'items' => $items,
                ]
            ]
        ];
        $response = $this->paypal->createOrder($data);
        

        if (isset($response['id'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return $link['href'];
                }
            }
        }
        return null;
    }

    public function executePayment($token)
    {
        return $response = $this->paypal->capturePaymentOrder($token);

        if ($response['status'] === 'COMPLETED') {
            return true;
        }
        return false;
    }
}
