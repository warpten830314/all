<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller
{
    public function index()
    {
        if (session('adminMsg'))
        {
            redirect('./admin.php?c=index&a=index');
        }
        $this->display();
    }
    public function check()
    {
        $username = I('username');
        $password = I('password');
        if ($username !== '')
        {
            if ($password !== '')
            {
                $res = D('Admin')->getAdminName($username);
                if ($res)
                {
                    if (md5($password.'sing_cms') == $res['password'])
                    {
                        session('adminMsg',$res);
                        show(1,'登录成功');
                    }
                    else
                    {
                        show(0,'密码错误');
                    }
                }
                else
                {
                    show(0,'该用户不存在');
                }
            }
            else
            {
                show(0,'密码不能为空');
            }
        }



        else
        {
            show(0,'用户名不能为空');
        }
    }
    public function loginout()
    {
        session('adminMsg',null);
        redirect('./admin.php?c=login&a=index');
    }
}