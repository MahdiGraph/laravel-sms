<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SMS Drivers
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following sms provider to use.
    | You can switch to a different driver at runtime.
    |
    */
    'default' => 'ippanel',

    'drivers' => [
        'ippanel' => [
            'key'        => '',
            'originator' => '+9890000',
            //            'patterns' => [
            //                'verify' => [
            //                    'pattern_code' => '',
            //                ],
            //            ],
            'SEND_MESSAGE_API' => 'http://rest.ippanel.com/v1/messages',
            'SEND_PATTERN_API' => 'http://rest.ippanel.com/v1/messages/patterns/send',
        ],
    ],

    'map' => [
        'ippanel' => \Metti\LaravelSms\Drivers\Ippanel\Ippanel::class,
    ],
];
