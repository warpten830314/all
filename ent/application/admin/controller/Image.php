<?php
namespace app\admin\controller;

use think\Controller;

class Image extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}