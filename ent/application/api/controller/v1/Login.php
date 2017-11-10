<?php
namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\ApiException;
use app\common\lib\IAuth;
use think\Cache;
use think\Exception;

class Login extends Common
{
    public function save()
    {
        $code = intval(input('post.code'));
        $realcode = intval(Cache::get('Sms'));
        $phone = input('post.phone');
//        if ($code != $realcode)
//        {
//            return show(0,'验证码错误',[],400);
//        }
        $token = IAuth::setAppAccessToken($phone);
        $data = [
            'token' => $token,
            'time_out' => strtotime('+7days')
        ];
        //判断用户是否是第一次登录,第一次登录就添加一条新用户数据,不是就更新用户数据
        //根据手机号查找用户信息
        $res = model('User')->get(['phone' => $phone]);
        if (!$res)
        {
            $data['username'] = '橙子'.$phone;
            $data['password'] = '';
            $data['sex'] = '';
            $data['status'] = 1;
            $data['phone'] = $phone;
            try
            {
                $user_id = model('User')->save($data);
            }catch (Exception $e)
            {
                throw new ApiException($e->getMessage(),501);
            }
        }
        else
        {
            $user_id = $res['id'];
            $data['status'] = 1;
            try
            {
                model('User')->save($data,['phone' => $phone]);
            }catch (Exception $e)
            {
                throw new ApiException($e->getMessage(),500);
            }
        }
        //给前端返回数据,携带 token
        //为了安全性需要对token进行加密
        $res = [
            'token' => (new Aes())->encrypt($token.'||'.$user_id)
        ];
        return show(1,'登录成功',$res);
    }
}