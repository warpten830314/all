<?php
namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function check()
    {
        if (request()->isPost())
        {
            $username = input('username');
            $password = input('password');
            $res = model('AdminUser')->get(['username'=>$username]);
            if (!$res)
            {
                $this->error('用户名不存在');
            }
            if (md5($password) != $res['password'])
            {
                $this->error('密码错误');
            }
            session('user',$res,'wang');
            $this->success('登陆成功',url('index/index'));
        }
    }
}