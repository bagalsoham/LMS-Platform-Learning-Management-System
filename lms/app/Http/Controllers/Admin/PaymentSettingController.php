<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{

    function index(): View
    {
        return view('admin.payment-setting.index');
    }

    function paypalSetting(Request $request): RedirectResponse
    {
        //dd($request ->all());

        $validatedData = $request->validate([
            'paypal_mode' => ['required', 'in:live,sandbox'],
            'paypal_client_id' => ['required'],
            'paypal_client_secret' => ['required'],
            'paypal_currency' => ['required'],
            'paypal_rate' => ['required', 'numeric'],
            'paypal_app_id' => ['required'],
        ]);

        foreach ($validatedData as $key => $value) {
            PaymentSetting::updateOrCreate(['key' => $key], ['value' => $value]); //either update by finding the key or update
        }

        Cache::forget(key: 'gatewaySettings');


        notyf()->success("Update Successfully!");

        return redirect()->back();
    }
    function stripeSetting(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
            'stripe_status' => ['required', 'in:active,inactive'],
            'stripe_currency' => ['required'],
            'stripe_rate' => ['required'],
            'stripe_publishable_key' => ['required'],
            'stripe_secret' => ['required'],
        ]);

        foreach($validatedData as $key => $value) {
            PaymentSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('gatewaySettings');

        notyf()->success("Update Successfully!");

        return redirect()->back();
    }

    function razorpaySetting(Request $request) : RedirectResponse{
        $validatedData = $request->validate([
            'razorpay_status' => ['required', 'in:active,inactive'],
            'razorpay_currency' => ['required'],
            'razorpay_rate' => ['required'],
            'razorpay_key' => ['required'],
            'razorpay_secret' => ['required'],
        ]);

        foreach($validatedData as $key => $value) {
            PaymentSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('gatewaySettings');

        notyf()->success("Update Successfully!");

        return redirect()->back();
    }
}
