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
            'key' => '',
            'originator' => '+9890000',
//            'patterns' => [
//                'verify' => [
//                    'pattern_code' => '',
//                ],
//            ]
        ],
    ],

    'map' => [
        'ippanel' => \Metti\LaravelSms\Drivers\Ippanel\Ippanel::class
    ],
];