<p style="display: flex;align-items: center;justify-content: center;"><img alt="Laravel SMS" src="resources/images/sms.png?raw=true"></p>



# Laravel SMS Integration Package

[![Software License][ico-license]]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads on Packagist][ico-download]][link-packagist]
[![Maintainability](https://api.codeclimate.com/v1/badges/03c352daab19de73191a/maintainability)](https://codeclimate.com/github/MahdiGraph/laravel-sms/maintainability)
[![StyleCI](https://github.styleci.io/repos/7548986/shield?style=flat&branch=6.x)](https://github.styleci.io/repos/7548986)
[![Quality Score][ico-code-quality]][link-code-quality]

This is a Laravel Package for SMS Integrations. This package supports `Laravel 5.8+`.

> This packages works with multiple drivers, and you can create custom drivers if you can't find them in the [current drivers list](#list-of-available-drivers) (below list).

- [داکیومنت فارسی][link-fa]
- [English documents][link-en]

# List of contents
- [List of available drivers](#list-of-available-drivers)
- [Install](#install)
- [Configure](#configure)
- [How to use](#how-to-use)

# List of available drivers

- [ippanel](https://ippanel.com/) :heavy_check_mark:
- Others are under way.

**Help me to add the gateways below by creating `pull requests`**

- [twilio](https://twilio.com)
- [kavenegar](https://kavenegar.com)
- [sms](https://sms.ir)
- [farazsms](https://farazsms.com)
- [melipayamak](https://melipayamak.com)
- ...

## Install

Via Composer

``` bash
$ composer require mahdigraph/laravel-sms
```

## Configure

If you are using `Laravel 5.5` or higher then you don't need to add the provider and alias. (Skip to b)

a. In your `config/app.php` file add these two lines.

```php
// In your providers array.
'providers' => [
    ...
    \Metti\LaravelSms\LaravelSMSServiceProvider::class,
],

// In your aliases array.
'aliases' => [
    ...
    'SendSMS' => \Metti\LaravelSms\Facade\SendSMS::class,
],
```

b. then run `php artisan vendor:publish` to publish `config/sms.php` file in your config directory.

In the config file you can set the `default driver` to use for all your sms requests. But you can also change the driver at runtime.

Choose what sms provider you would like to use in your application. Then make that as default driver so that you don't have to specify that everywhere. But, you can also use multiple sms providers in a project.

```php
// Eg. if you want to use ippanel.
'default' => 'ippanel',
```

Then fill the credentials for that driver in the drivers array.

```php
'drivers' => [
    'ippanel' => [
        // Fill in the credentials here.
        'key' => '00000000-0000-0000-0000-000000000000', // API Key
        'originator' => '+9890000', // Sender Number
        'patterns' => [ // patterns only if you want to use them.
            'contact' => [ // pattern name
                'pattern_code' => 'abcd-efgh-ijkl-mnop', // pattern code from your sms provider
                'values' => [ // values only if you want to set default values for your patterns.
                    'support_phone' => '021-123456789'
                ]
            ]
        ] 
    ],
    ...
]
```

## How to use
```php
// Sending Text Messages
SendSMS::textMessage('Hey You :)')
    ->recipients(['09121234567','09121234568'])
    ->send();

// Sending Pattern Messages
SendSMS::via('ippanel')
    ->patternMessage('contact',['support_phone' => '021-123456789'])
    ->recipients('09121234567')
    ->send();
```

## Security

If you discover any security related issues, please email immahdigraph@gmail.com instead of using the issue tracker.

## Credits

- [MahdiGraph][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT).

[ico-code-quality]: https://img.shields.io/scrutinizer/quality/g/mahdigraph/laravel-sms.svg?label=Code%20Quality&style=flat-square

[link-fa]: README-FA.md
[link-en]: README.md
[link-code-quality]: https://scrutinizer-ci.com/g/mahdigraph/laravel-sms
[link-author]: https://github.com/MahdiGraph
[link-contributors]: https://github.com/MahdiGraph/laravel-sms/graphs/contributors
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/mahdigraph/laravel-sms.svg?style=flat-square
[ico-download]: https://img.shields.io/packagist/dt/mahdigraph/laravel-sms.svg?color=%23F18&
[link-packagist]: https://packagist.org/packages/mahdigraph/laravel-sms
