<?php

namespace App\Providers;

use App\Service\PaymentGatewaySettingService;
use Illuminate\Support\ServiceProvider;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentGatewaySettingService::class, function () {
            return new  PaymentGatewaySettingService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $paymentGatewaySettings = $this->app->make(PaymentGatewaySettingService::class);
        $paymentGatewaySettings->setGlobalSettings();
    }
}
