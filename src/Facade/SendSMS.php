<?php

namespace Metti\LaravelSms\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class SendSMS.
 */
class SendSMS extends Facade
{
    /**
     * @return string
     * @description Get the registered name of the component.
     */
    public static function getFacadeAccessor()
    {
        return \Metti\LaravelSms\SendSMS::class;
    }
}
