<?php
namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
{
    public function index()
    {
        $res = model('News')->getLunboNewsByLimit(4);
        return $res;
    }
}