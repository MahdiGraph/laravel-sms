<?php

namespace Metti\LaravelSms\Contracts;

interface DriverInterface
{
    /**
     * @return mixed
     * @description send message action
     */
    public function sendMessage();
}
