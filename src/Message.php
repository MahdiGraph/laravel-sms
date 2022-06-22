<?php

namespace Metti\LaravelSms;

use Metti\LaravelSms\Exceptions\MessageException;
use Ramsey\Uuid\Uuid;

class Message
{
    /**
     * @var string
     * @description message's unique id (uuid)
     */
    protected $uuid;

    /**
     * @var string
     * @description message's type (text or pattern & ...)
     */
    public $type;

    /**
     * @var
     * @description message's body or pattern data
     */
    public $data;

    /**
     * @var string
     * @description message's driver name
     */
    public $driver;

    /**
     * @var
     * @description message's originator/sender number
     */
    public $originator;

    /**
     * @var array
     * @description message's recipient number/numbers
     */
    public $recipients;

    /**
     * @var
     * @description response from driver
     */
    public $response;

    /**
     * @var bool
     * @description message's status (sent or not)
     */
    public $is_sent = false;

    public function __construct()
    {
        $this->recipients = [];
        $this->uuid();
    }

    /**
     * Get the driver name.
     *
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param $originator
     *
     * @return $this
     * @description set message originator/sender number
     */
    public function originator($originator)
    {
        $this->originator = (string) $originator;

        return $this;
    }

    /**
     * @param $recipients
     *
     * @return $this
     * @description send message to recipient number/numbers
     */
    public function recipients($recipients)
    {
        $this->recipients = (array) $recipients;

        return $this;
    }

    /**
     * @param $text
     *
     * @return $this
     * @description set message text
     */
    public function textMessage($text)
    {
        $this->type = 'text';
        $this->data = [
            'text' => $text,
        ];

        return $this;
    }

    /**
     * @param $pattern_id
     * @param $params
     *
     * @return $this
     * @description send message by pattern (pattern must be set in sms config file)
     */
    public function patternMessage($pattern_id, $params)
    {
        $this->type = 'pattern';
        $this->data = [
            'pattern_id' => $pattern_id,
            'values'     => $params,
        ];

        return $this;
    }

    /**
     * @return mixed
     * @description get response from driver
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     * @description get message's status (sent or not)
     */
    public function isSent()
    {
        return $this->is_sent;
    }

    /**
     * @return string
     * @description get message's unique id (uuid)
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @throws MessageException
     *
     * @return void
     * @description validate message parameters
     */
    public function validate()
    {
        if (empty($this->type)) {
            throw new MessageException('نوع پیام مشخص نمیباشد');
        }

        if ($this->type == 'text') {
            if (empty($this->data['text'])) {
                throw new MessageException('پیام حاوی متن نمیباشد');
            }
        }

        if ($this->type == 'pattern') {
            if (empty($this->data['pattern_id'])) {
                throw new MessageException('آیدی پترن الزامی است');
            }
        }

        if (empty($this->originator)) {
            throw new MessageException('ارسال کننده پیام مشخص نمیباشد');
        }

        if (empty($this->recipients)) {
            throw new MessageException('دریافت کننده پیام مشخص نمیباشد');
        }
    }

    /**
     * Set message uuid.
     *
     * @param $uuid|null
     *
     * @throws \Exception
     */
    private function uuid($uuid = null)
    {
        if (empty($uuid)) {
            $uuid = Uuid::uuid4()->toString();
        }
        $this->uuid = $uuid;
    }
}
