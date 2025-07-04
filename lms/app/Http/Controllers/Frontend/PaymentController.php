<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Service\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    function orderFailed()
    {
        return view('frontend.pages.order-failed');
    }
    function orderSuccess()
    {
        return view('frontend.pages.order-success');
    }
    function payWithPaypal()
    {
        $provider = new PayPalClient($this->paypalConfig()); // created an instance for making payment request
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $provider->setAccessToken($paypalToken);

        $payableAmount = cartTotal();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [ // wrapped inside an array
                    'amount' => [
                        'currency_code' => config('paypal.currency'),
                        'value' => $payableAmount,
                    ]
                ]
            ]
        ]);

        //dd($response);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']); //redirect outside of out use away
                }
            }
        }
    }
    function paypalSuccess(Request $request)
    {

        $provider = new PayPalClient();
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $capture = $response['purchase_units'][0]['payments']['captures'][0];

            $transactionId = $capture['id'];
            $mainAmount = cartTotal();
            $paidAmount = $capture['amount']['value'];
            $currency = $capture['amount']['currency_code'];

            try {
                OrderService::storeOrder(
                    $transactionId,
                    Auth::user()->id,
                    'approved',
                    $mainAmount,
                    $paidAmount,
                    $currency,
                    'paypal',
                );


                return redirect()->route('order.success');
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        return redirect()->route('order.failed');
    }
    function paypalConfig(): array
    {
        return [
            'mode'    => config('gateway_settings.paypal_mode'),
            'sandbox' => [
                'client_id'         => config('gateway_settings.paypal_client_id'),
                'client_secret'     => config('gateway_settings.paypal_client_secret'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('gateway_settings.paypal_client_id'),
                'client_secret'     => config('gateway_settings.paypal_client_secret'),
                'app_id'            => config('gateway_settings.paypal_app_id'),
            ],

            'payment_action' => "Sale",
            'currency'       => config('gateway_settings.paypal_currency'),
            'notify_url'     => '',
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];
    }

    function payWithStripe()
    {
        Stripe::setApiKey(config('gateway_settings.stripe_secret'));

        $payableAmount = (cartTotal() * 100) * config('gateway_settings.stripe_rate');//convert to cents 
        $quantityCount = cartCount();

        $response = StripeSession::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => config('gateway_settings.stripe_currency'),
                        'product_data' => [
                            'name' => 'Course'
                        ],
                        'unit_amount' => $payableAmount
                    ],
                    'quantity' => $quantityCount
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel')
        ]);

        return redirect()->away($response->url);
    }

    function stripeSuccess(Request $request) {
        Stripe::setApiKey(config('gateway_settings.stripe_secret'));

        $response = StripeSession::retrieve($request->session_id);
        if($response->payment_status === 'paid') {
            $transactionId = $response->payment_intent;
            $mainAmount = cartTotal();
            $paidAmount = $response->amount_total / 100;
            $currency = $response->currency;

            try {
                OrderService::storeOrder(
                    $transactionId,
                    Auth::user()->id,
                    'approved',
                    $mainAmount,
                    $paidAmount,
                    $currency,
                    'stripe',
                );

                return redirect()->route('order.success');
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return redirect()->route('order.failed');
    }

    function stripeCancel(Request $request) {
        return redirect()->route('order.failed');
    }

}
