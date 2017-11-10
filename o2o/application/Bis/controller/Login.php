<?php
namespace app\Bis\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        //判断session
        if (session('loginUser','','bis'))
        {
            //跳转
            $this->redirect('index/index');
        }
        if (request()->isPost())
        {
            $data = input('post.');
            //数据校验
            $validate = validate('BisAccount');
            $res = $validate->scene('login')->check($data);
            if (!$res)
            {
                $this->error($validate->getError());
            }
            $res = model('BisAccount')->get(['username'=>$data['username']]);
            if (!$res)
            {
                $this->error('该用户不存在');
            }
            //匹配密码
            if ($res->password != md5($data['password'].$res->code))
            {
                $this->error('登录失败');
            }
            session('loginUser',$res,'bis');
            $this->success('登陆成功',url('bis/index/index'));
        }
        return $this->fetch();
    }
    public function logout()
    {
        //session置空
        session('loginUser',null,'bis');
        $this->redirect('login/index');
    }
}