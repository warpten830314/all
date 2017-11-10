<?php
namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\Aliyun;
use think\Cache;
use think\Validate;

class SendCode extends Common
{
    public function save()
    {
        //判断是否为post请求
        if (!request()->isPost())
        {
            return show(0,'请求不合法',[],400);
        }
        $phone = intval((new Aes())->decrypt(input('post.phone')));
        //判断电话号码是否符合规范(11位数字)
        $validate = new Validate(['phone'=> 'require|number|length:11']);
        if ($validate->check($phone))
        {
            return show(0,$validate->getError(),[],400);
        }
        //发送验证码
        if (Aliyun::getInstance()->setSms($phone))
        {
            return show(1,'验证码发送成功',[]);
        }
        return show(0,'验证码发送失败',[],201);
    }
    public function index()
    {
        $phone = input('get.phone');
        $phone = (new Aes())->encrypt($phone);
        return show(1,$phone,[]);
    }
}