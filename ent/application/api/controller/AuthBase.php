<?php
namespace app\api\controller;

use app\common\lib\Aes;
use app\common\lib\ApiException;

class AuthBase extends Common
{
    public $user = null;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        if (!$this->isLogin())
        {
            throw new ApiException('用户未登录',403);
        }
    }
    public function isLogin()
    {
        //获取前端发送过来的token(access_user_token)
        $token = $this->header;
//        $token = request()->header();
        $token = $token['access_user_token'];
        //对access_token进行基本验证
        if (!$token)
        {
            return false;
        }
        //对access_token进行解密,获取真正的token值
        $token = (new Aes())->decrypt($token);
        if (!strpos($token,'||'))
        {
            return false;
        }
        $token = explode('||',$token);
        $token = $token[0];
        $res = model('User')->get(['token' => $token]);
        if (!$res || $res['status'] != 1)
        {
            return false;
        }
        if ($res['time_out'] < time())
        {
            return false;
        }
        $this->user = $res;
        return true;
    }
}