<?php
namespace app\common\lib;

use aliyun\api_demo\SmsDemo;
use think\Cache;
use think\Exception;
use think\Log;

class Aliyun
{
    //单例模式
    /**
     * 私有变量存储Aliyun类的实例
     * @var null
     */
    private static $_instance = null;

    /**
     * 私有构造方法
     * liyun constructor.
     */
    private function __construct()
    {

    }
    public static function getInstance()
    {
        if (is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $phone
     * @return bool
     */
    public static function setSms($phone)
    {
        $code = rand(1000,9999);
        $phone = $phone;
        $signName = '源文科技';
        $templateCode = 'SMS_109405011';
        try
        {
            $res = SmsDemo::sendSms($signName,$templateCode,$phone,Array("code"=>$code));
        }catch (Exception $e)
        {
            //将错误记录到日志中
            Log::write('aliyun send error-----'.$e->getMessage());
            return false;
        }
        if ($res->Code != 'OK')
        {
            Log::write('aliyun send error-----'.$res->Code);
            return false;
        }
        Cache::set('Sms',$code,60);
        return true;
    }
}