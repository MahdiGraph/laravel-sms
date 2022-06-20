<?php

namespace Metti\LaravelSms\Exceptions;

class MessageException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        if (is_null($message)){
            $message = 'unknown error happened';
        }
        if (is_array($message)){
            $text = '';
            foreach ($message as $key => $value){
                if (!empty($text)){
                    $text .= ' | ';
                }
                if (is_array($value)) {
                    $text .= json_encode($value);
                }else {
                    $text .= $value;
                }
            }
            $message = $text;
        }
        parent::__construct($message, $code, $previous);
    }
}