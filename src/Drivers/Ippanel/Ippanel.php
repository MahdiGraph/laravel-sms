<?php

namespace Metti\LaravelSms\Drivers\Ippanel;

use GuzzleHttp\Client;
use Metti\LaravelSms\Abstracts\Driver;
use Metti\LaravelSms\Exceptions\DriverException;
use Metti\LaravelSms\Exceptions\ResponseErrorException;

class Ippanel extends Driver
{
    /**
     * Guzzle Client.
     *
     * @var object
     */
    protected $client;

    /**
     * Driver config settings.
     *
     * @var object
     */
    protected $settings;

    public $message;

    public function __construct($message, $settings)
    {
        $this->client = new Client();
        $this->message = $message;
        $this->settings = (array) $settings;
    }

    public function sendMessage()
    {
        if ($this->message->type == 'text') {
            $res = $this->sendTextMessage();
        } elseif ($this->message->type == 'pattern') {
            $res = $this->sendPatternMessage();
        } else {
            throw new DriverException('این نوع پیام توسط آیپی پنل پشتیبانی نمیشود');
        }

        $body = (array) @json_decode($res->getBody()->getContents(), true);

        $this->message->response = $body;

        // validate response
        if (@$body['status'] !== 'OK') {
            throw new ResponseErrorException([
                'message'  => $this->getStatusCodeMessage(@$body['code']),
                'response' => $body,
            ]);
            $this->message->is_sent = false;
        } else {
            $this->message->is_sent = true;
        }

        return $this->message;
    }

    private function sendPatternMessage()
    {
        if (count($this->message->recipients) > 1) {
            throw new DriverException('امکان ارسال پترن بطور همزمان به چندین شماره در آیپی پنل پشتیبانی نمیشود');
        }

        $values = array_merge((array) @$this->settings['patterns'][@$this->message->data['pattern_id']]['values'], (array) @$this->message->data['values']);
        foreach($values as $key => $value){
            if (!is_string($value)){
                $values[$key] = (string)$value;
            }
        }

        return $this->client->request('POST', $this->settings['SEND_PATTERN_API'], [
            'json' => [
                'originator'   => $this->message->originator,
                'recipient'    => $this->message->recipients[0],
                'pattern_code' => @$this->settings['patterns'][@$this->message->data['pattern_id']]['pattern_code'],
                'values'       => $values,
            ],
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => "AccessKey {$this->settings['key']}",
            ],
            'http_errors' => false,
        ]);
    }

    private function sendTextMessage()
    {
        return $this->client->request('POST', $this->settings['SEND_MESSAGE_API'], [
            'json' => [
                'originator' => $this->message->originator,
                'recipients' => $this->message->recipients,
                'message'    => $this->message->data['text'],
            ],
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => "AccessKey {$this->settings['key']}",
            ],
            'http_errors' => false,
        ]);
    }

    private function getStatusCodeMessage($statusCode)
    {
        $translations = [
            400   => 'خطایی رخ داد',
            401   => 'احراز هویت با شکست مواجه شد',
            422   => 'برخی از ورودی ها صحیح نیست',
            10023 => 'شماره ارسال کننده یافت نشد',
            10004 => 'شماره ارسال کننده متعلق به شما نیست',
            10015 => 'پارامتر های پترن صحیح نیست',
        ];
        if (in_array($statusCode, array_keys($translations))) {
            return $translations[$statusCode];
        } else {
            return 'خطای ناشناخته';
        }
    }
}
