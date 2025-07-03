<?php

namespace App\Service;

use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Cache;

class PaymentGatewaySettingService
{
    function getSettings():array{
        return Cache::rememberForever('gatewaySettings',function(){
            return PaymentSetting::pluck('value','key')->toArray();//['KEY'=>'VALUE']
        });
    }
    function setGlobalSettings(){
        $settings = $this ->getSettings();
        config()->set('gateway_settings', $settings);//config ('gateway_settings,'KEY','VALUE')
    }
}
