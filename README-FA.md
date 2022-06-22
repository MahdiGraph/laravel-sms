<p style="display: flex;align-items: center;justify-content: center;"><img alt="لاراول اس ام اس" src="resources/images/sms.png?raw=true"></p>



# پکیج ارسال پیامک در لاراول

[![Software License][ico-license]]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads on Packagist][ico-download]][link-packagist]
[![Maintainability](https://api.codeclimate.com/v1/badges/03c352daab19de73191a/maintainability)](https://codeclimate.com/github/MahdiGraph/laravel-sms/maintainability)
[![StyleCI](https://github.styleci.io/repos/7548986/shield?style=flat&branch=6.x)](https://github.styleci.io/repos/7548986)
[![Quality Score][ico-code-quality]][link-code-quality]

این پکیج برای استفاده از سرویس دهنده های پیامکی در لاراول است. پشتیبانی از `لاراول 5.8+`.

> این پکیج با درایور های مختلف سازگار است, در صورتی که درایور شما وجود نداشت میتوانید درایور خود را ایجاد کنید [current drivers list](#درایور-های-موجود) (لیست درایور های موجود).

- [داکیومنت فارسی][link-fa]
- [English documents][link-en]

# لیست محتوا 
- [درایور های موجود](#درایور-های-موجود)
- [نصب](#نصب)
- [تنظیمات](#تنظیمات)
- [نحوه استفاده](#نحوه-استفاده)

# درایور های موجود

- [آی پی پنل](https://ippanel.com/) :heavy_check_mark:
- در حال افزودن ...

**به من در افزودن درایور ها کمک کنید `pull requests`**

- [twilio](https://twilio.com)
- [کاوه نگار](https://kavenegar.com)
- [ایده پردازان](https://sms.ir)
- [فراز اس ام اس](https://farazsms.com)
- [ملی پیامک](https://melipayamak.com)
- ...

## نصب

با استفاده از composer
``` bash
$ composer require mahdigraph/laravel-sms
```

## تنظیمات

در صورتی که از `لاراول 5.5` یا بالاتر استفاده میکنید نیازی به افزودن دستی provider و alias ها نیست. (به مرحله b بروید)

a. در فایل `config/app.php` این دو خط را اضافه کنید.

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

b. سپس دستور `php artisan vendor:publish` را اجرا کنید تا فایل `config/sms.php` برای شما ایجاد شود.

در فایل کانفیگ شما میتوانید `سرویس دهنده پیامکی پیشفرض` خود را تعیین کنید. ولی شما هر زمان میتوانید این مقدار پیشفرض را تغییر دهید .

انتخاب کنید که ترجیح میدهید از کدام سرویس دهنده پیامکی در برنامه خود استفاده کنید سپس آن را به عنوان درایور پیشفرض تعیین کنید که هربار نیازی به تعریف آن نداشته باشید. همچنین شما میتوانید از چندین سرویس دهنده مختلف در یک برنامه استفاده کنید

```php
// Eg. if you want to use ippanel.
'default' => 'ippanel',
```

سپس مشخصات مربوط به سرویس دهنده پیامکی را در آرایه drivers وارد کنید.

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

## نحوه استفاده
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

## امنیتی
در صورتی که هرگونه مشکل امنیتی پیدا کردید ، لطفا به ایمیل immahdigraph@gmail.com گزارش را ارسال کنید

## توسعه دهندگان
- [MahdiGraph][link-author]
- [All Contributors][link-contributors]

## License

توسعه و تولید تحت لایسنس MIT است.

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
