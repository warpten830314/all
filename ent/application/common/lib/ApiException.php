<?php
namespace app\common\lib;


use think\Exception;
use Throwable;

class ApiException extends Exception
{
    public $httpCode = 500;
    public function __construct($message = "", $httpCode = 500, $code = 0, Throwable $previous = null)
    {
        $this->httpCode = $httpCode;
        parent::__construct($message, $code, $previous);
    }
}