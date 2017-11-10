<?php
namespace app\index\controller;

use think\Controller;

class Login extends Controller
{
    public function login()
    {
        $res = session('o2o_user','','lee');
        if ($res)
        {
            $this->redirect(url('index/index'));
        }
        return $this->fetch();
    }
    public function check()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            $validate = validate('User');
            $res = $validate->scene('login')->check($data);
            if (!$res)
            {
                $this->error($validate->getError());
            }
            $res = model('User')->get(['username'=>$data['username']]);
            if (!$res)
            {
                $this->error('用户名不存在');
            }
            if ($res->status != 1)
            {
                $this->error('该账号未激活,请前往邮箱激活');
            }
            if ($res['password'] !== md5($data['password'].$res['code']))
            {
                $this->error('密码错误');
            }
            model('User')->save([
                'last_login_time' => time(),
                'last_login_ip' => get_client_ip()
            ],['id' => $res->id]);
            session('o2o_user',$res,'lee');
            $this->success('登陆成功',url('index/index'));
        }
    }
    public function logout()
    {
        session(null,'lee');
        //界面跳转
        $this->redirect(url('login/login'));
    }
}
