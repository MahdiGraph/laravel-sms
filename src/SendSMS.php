<?php

namespace Metti\LaravelSms;

use Metti\LaravelSms\Contracts\DriverInterface;
use Metti\LaravelSms\Exceptions\DriverException;

class SendSMS
{
    /**
     * @var array|mixed
     * @description get all configs
     */
    private $config;

    /**
     * @var
     * @description driver name
     */
    protected $driver;

    /**
     * @var Message
     * @description message object
     */
    protected $message;

    public function __construct(array $config = [])
    {
        $config = function_exists('config') ? config('sms') : [];
        $this->config = empty($config) ? $this->loadDefaultConfig() : $config;
        $this->message = new Message();
        $this->via(@$this->config['default']);
    }

    /**
     * @param $driver
     *
     * @throws DriverException|\ReflectionException
     *
     * @return $this
     * @description set sms driver (driver must be set in sms config file)
     */
    public function via($driver)
    {
        $this->validateDriver($driver);
        $this->driver = $driver;
        $this->message->originator(@$this->config['drivers'][$driver]['originator']);

        return $this;
    }

    /**
     * @param $options array
     *
     * @return $this
     * @description set driver config
     */
    public function configDriver($options)
    {
        $this->config['drivers'][$this->driver] = array_merge($this->config['drivers'][$this->driver], (array) $options);

        return $this;
    }

    /**
     * @param $originator
     *
     * @return $this
     * @description set message originator/sender number
     */
    public function origanator($originator)
    {
        $this->message = $this->message->originator($originator);

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
        $this->message = $this->message->recipients($recipients);

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     * @description set message text
     */
    public function textMessage($text)
    {
        $this->message = $this->message->textMessage($text);

        return $this;
    }

    /**
     * @param $pattern_id
     * @param $params
     *
     * @return $this
     * @description send message by pattern (pattern must be set in sms config file)
     */
    public function patternMessage($pattern_id, $params = [])
    {
        $this->message = $this->message->patternMessage($pattern_id, $params);

        return $this;
    }

    /**
     * @throws Exceptions\MessageException
     *
     * @return mixed
     * @description send message
     */
    public function send()
    {
        if (empty($this->message->originator)) {
            $this->message->originator(@$this->config['drivers'][$this->driver]['originator']);
        }
        $this->message->driver = $this->driver;
        $this->message->validate();

        return $this->getDriverInstance()->sendMessage();
    }

    /**
     * @return string
     * @description get default config file path
     */
    public static function getDefaultConfigPath(): string
    {
        return dirname(__DIR__).'/config/sms.php';
    }

    /**
     * @throws \ReflectionException
     * @throws DriverException
     * @description validate driver name
     */
    private function validateDriver($driver)
    {
        if (empty($driver)) {
            throw new DriverException('درایور مشخص نمیباشد');
        }

        if (empty(@$this->config['drivers'][$driver]) || empty(@$this->config['map'][$driver])) {
            throw new DriverException('درایور مورد نظر در فایل کانفیگ یافت نشد ، لطفا پکیج را آپدیت کنید');
        }

        if (!class_exists(@$this->config['map'][$driver])) {
            throw new DriverException('آدرس مسیر درایور یافت نشد ، لطفا پکیج را آپدیت کنید');
        }

        $reflection = new \ReflectionClass(@$this->config['map'][$driver]);

        if (!$reflection->implementsInterface(DriverInterface::class)) {
            throw new DriverException("Driver must be an instance of Contracts\DriverInterface.");
        }

        return true;
    }

    /**
     * @return mixed
     * @description get driver instance
     */
    private function getDriverInstance()
    {
        $class = $this->config['map'][$this->driver];

        return new $class($this->message, $this->config['drivers'][$this->driver]);
    }

    /**
     * @return mixed
     * @description load default config file
     */
    private function loadDefaultConfig()
    {
        return require static::getDefaultConfigPath();
    }
}
