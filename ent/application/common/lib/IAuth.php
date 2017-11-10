<?php
namespace app\common\lib;

use think\Cache;
use think\Exception;
use app\common\lib\Aes;

class IAuth
{
    /**
     * 校验sign的合法性
     * @param array $data
     * @return bool  合法就返回true  不合法返回false
     */
    public static function checkSignAuth($data = [])
    {
        if (empty($data['sign']))
        {
            return false;
        }
        //解密sign
        $signStr = (new Aes())->decrypt($data['sign']);
        //将字符串转化为数组
        parse_str($signStr,$arr);
        //用did判断是否合法
        if (!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did'])
        {
            return false;
        }
        if (Cache::get($data['sign']))
        {
            return false;
        }
        if (time() - $arr['time']/1000 > config('app.app_sign_tim'))
        {
            return false;
        }
        return true;
    }
    public static function setSign($data = [])
    {
        //1:排序
        ksort($data);
        //2:拼接字符串
        $str = http_build_query($data);
        //AES加密字符串
        $aesStr = (new Aes())->encrypt($str);
        return $aesStr;
    }
    public static function setAppAccessToken($phone)
    {
        $token = md5(uniqid(md5(microtime(true)),true));
        $token = sha1($token.$phone);
        return $token;
    }
}