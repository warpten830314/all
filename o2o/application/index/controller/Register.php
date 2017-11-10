<?php
namespace app\index\controller;

use think\Controller;
use think\captcha\Captcha;

class Register extends Controller
{
    public function register()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            $validate = validate('User');
            $res = $validate->scene('add')->check($data);
            if (!$res)
            {
                $this->error($validate->getError());
            }
            if (!captcha_check($data['verifycode']))
            {
                $this->error('验证码不正确');
            }
            unset($data['verifycode']);
            unset($data['se_password']);
            $data['code'] = mt_rand(1000,10000);
            $data['password'] = md5($data['password'].$data['code']);
            $res = model('User')->add($data);
            if (!$res)
            {
                $this->error('注册失败');
            }
            else
            {
                //发送邮件
                $to = $data['email'];
                $title = '账号激活';
                $content = '请点击以下链接激活账号<br><a href="http://o2o.local/index.php/index/register/waiting?id='.$res.'" target="_blank"></a>';
                \phpmailer\Email::send($to,$title,$content);
                //准备邮箱地址
                $emailHost = explode('@',$data['email'])[1];
                $emailHost = 'http://mail.'.$emailHost;
                $this->success('请前往邮箱进行账号激活',$emailHost);
            }
        }
        return $this->fetch();
    }
    public function waiting($id)
    {
        if (empty($id))
        {
            return '';
        }
        //根据id激活某个账号
        model('User')->save(['status'=>1],['id'=>$id]);
        return $this->fetch();
    }
    //前端检测用户名是否存在的方法
    public function checkname()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            $res = model('User')->get($data);
            if ($res)
            {
                $this->result('',0);
            }
            else
            {
                $this->result('',1);
            }
        }
    }
    public function random()
    {

    }
}
