<?php
namespace app\api\controller;

use app\common\lib\Aes;
use app\common\lib\ApiException;
use app\common\lib\IAuth;
use think\Cache;
use think\Controller;
use think\Exception;

class Common extends Controller
{
    public $header = null;
    protected function _initialize()
    {

    }

    //验证授权是否合法
    public function checkSignAuth()
    {
        $header = request()->header();
        $this->header = request()->header();
        //基础参数判断
        if (empty($header['app_type']) || !in_array($header['app_type'],config('app_type')))
        {
            throw new ApiException('app_type错误',400);
        }
        //sign验证
        if (!IAuth::checkSignAuth($header))
        {
            throw new ApiException('无权访问',401);
        }
        //设置sign字符串的缓存,用于以后的sign的唯一性验证
        Cache::set($header['sign'],1,70);
    }
    public function testSign()
    {
        $time = microtime();
        //获取十三位的时间戳
        list($t1,$t2) = explode(' ',$time);
        $time13 = $t2.ceil($t1*1000);
        //加密数据
        $data = [
            'app_type' => 'ios',
            'version' => 1,
            'did' => 'AEVEE',
            'time' => $time13,
        ];
        //1:排序
        ksort($data);
        //2:拼接字符串
        $str = http_build_query($data);
        //AES加密字符串
        $aesStr = (new Aes())->encrypt($str);
        echo $aesStr;
        exit();
    }
    public function getCatname($data)
    {
        if (!$data || !is_array($data))
        {
            return [];
        }
        try
        {
            $res = model('Category')->getAllCategory();
        }catch (Exception $e)
        {
            throw new ApiException('数据库错误',500);
        }
        $catname = [];
        foreach ($res as $one)
        {
            $catname[$one['id']] = $one['name'];
        }
        foreach ($data as $one)
        {
            $one['catname'] = $catname[$one['catid']];
        }
        //数组排序
        return $data;
    }
}