<?php
namespace app\api\controller;

use think\Controller;
use think\Request;

class Image extends Controller
{
    public function upload()
    {
        //实例化一个文件操作对象,并调用file方法
        $file = Request::instance()->file('file');
        //将文件移动到某个文件目录下
        $info = $file->move('upload');
        if ($info && $info->getPathname())
        {
            return show(1,'success','/'.$info->getPathname());
        }
        return show(0,'upload failed');
    }
}