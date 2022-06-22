<?php

namespace Metti\LaravelSms\Abstracts;

use Metti\LaravelSms\Contracts\DriverInterface;

abstract class Driver implements DriverInterface
{
    /**
     * @var object
     * @description Guzzle Client
     */
    protected $client;

    /**
     * @var object
     * @description Driver config settings
     */
    protected $settings;

    /**
     * @var
     * @description Message object
     */
    public $message;

    abstract public function __construct($message, $settings);

    /**
     * @return mixed
     * @description send message action
     */
    abstract public function sendMessage();
}
