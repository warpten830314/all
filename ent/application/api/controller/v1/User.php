<?php
namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\Aes;

class User extends Common
{
    public function read($id)
    {
        //验证是否登录
        //返回用户信息数据,为了安全性,需要对用户信息加密后返回
        $res = [
            (new Aes())->encrypt($this->user)
        ];
        return show(1,'OK',$res);
    }
}