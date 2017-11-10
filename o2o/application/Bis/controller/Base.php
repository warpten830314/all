<?php
namespace app\Bis\controller;

use think\Controller;

class Base extends Controller
{
    public $account;
    protected function _initialize()
    {
        //检测登录情况
        if (!$this->isLogin())
        {
            $this->redirect('login/index');
        }
    }
    public function isLogin()
    {
        $login_user = $this->getLoginUser();
        if (!$login_user)
        {
            return false;
        }
        return true;
    }
    public function getLoginUser()
    {
        //懒加载
        if (!$this->account)
        {
            $this->account = session('loginUser','','bis');
        }
        return $this->account;
    }
    public function getSeCityByCityPath($city_path)
    {
        if (empty($city_path))
        {
            return '';
        }
        if (preg_match('/,/',$city_path))
        {
            $cityArray = explode(',',$city_path);
            $cityId = $cityArray[1];
            return $cityId;
        }

    }
}