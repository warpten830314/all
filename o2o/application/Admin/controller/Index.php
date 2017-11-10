<?php
namespace app\Admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function w()
    {
        $res = \Map::getLngLat('大连市沙河口区软件园3号楼');
        print_r($res);
        return "欢迎来到😯o管理平台";
    }
}
