<?php
namespace Metti\LaravelSms;

use Illuminate\Support\ServiceProvider;

class LaravelSMSServiceProvider extends ServiceProvider
{
    /**
     * @return void
     * @description publish configurations
     */
    public function boot(){
        $this->publishes(
            [
                SendSMS::getDefaultConfigPath() => config_path('sms.php'),
            ],
            'config'
        );
    }

    public function register(){
        //
    }
}