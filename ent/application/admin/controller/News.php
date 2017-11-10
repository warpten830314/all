<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class News extends Controller
{
    public function index()
    {
        return $this->fetch('',[

        ]);
    }
    public function add()
    {
        return $this->fetch('',[
            'cats' => ['aa','bb','cc']
        ]);
    }
    public function edit()
    {
        $data = input('post.');
        $data['status'] = 0;
        $res = model('News')->save($data);
        if (!$res)
        {
            $this->error('添加失败');
        }
        $this->success('添加成功');
    }
    public function upload()
    {
        //实例化一个请求类
        $file = Request::instance()->file('file');
        $info = $file->move('upload');
        if (!$info)
        {
            return '';
        }
        else
        {
            return '/'.$info->getPathname();
        }
    }
}