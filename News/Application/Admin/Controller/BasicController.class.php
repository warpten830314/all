<?php
/**
 * Created by PhpStorm.
 * User: if-information
 * Date: 2017/8/21
 * Time: 下午8:50
 */
namespace Admin\Controller;
use Think\Controller;

class BasicController extends Controller
{
    public function index()
    {
        $this->display();
    }
}