<?php

namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    private $obj;

    protected function _initialize()
    {
        $this->obj = model('Category');
    }

    public function index()
    {
        //获取parent_id 接收来自子栏目的id
        $parent_id = input('parent_id',0,'intval');
        //通过model获取分类数据
        $data = $this->obj->getFirstNormalCategorys(intval($parent_id));
        return $this->fetch('',[
            'categories' => $data
        ]);
    }

    /**
     *修改状态的函数
     */
    public function status()
    {
        //获取数据
        $data = input();
        //校验
        $validate = validate('Category');
        $res = $validate->scene('status')->check($data);
        if (!$res)
        {
            $this->error($validate->getError());
        }
        $result = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if (!$result)
        {
            $this->error('更新状态失败');
        }
        $this->success('状态更新成功');
    }

    public function add()
    {
        $categories = $this->obj->getAllFirstNormalCategorys();
        return $this->fetch('',[
            'categories' => $categories
        ]);
    }

    public function save()
    {
        //获取前端发送过来的表单数据
        //判断请求类型
        if (!request()->isPost())
        {
            $this->error('请求失败');
        }
        $data = input('post.');
        //校验
        $validate = validate('Category');
        $res = $validate->scene('add')->check($data);
        if (!$res)
        {
            $this->error($validate->getError());
        }
        //添加数据库
        $result = $this->obj->save($data);
        if (!$result)
        {
            $this->error('新增失败');
        }
        $this->success('新增成功');
    }
    public function edit()
    {
        $id = input('id',0,'intval');
        //根据id查一行
        $category = $this->obj->get($id);
        $data = $this->obj->getAllFirstNormalCategorys();
        return $this->fetch('',[
            'category' => $category,
            'categories' => $data
        ]);
    }
    public function update()
    {
        $data = input();
        $validate = validate('category');
        $res = $validate->scene('update')->check($data);
        if (!$res)
        {
            $this->error($validate->getError());
        }
        //修改数据
        $result = $this->obj->save(['name'=>$data['name'],'parent_id'=>$data['parent_id']],['id'=>$data['id']]);
        if (!$result)
        {
            $this->error('更新失败');
        }
        $this->success('更新成功');
    }
    public function listorder()
    {
        $data = input('post.');
        $validate = validate('category');
        $res = $validate->scene('listorder')->check($data);
        if (!$res)
        {
            $this->error($validate->getError());
        }
        $res = $this->obj->save(['listorder'=>$data['listorder']],['id'=>$data['id']]);
        if (!$res)
        {
            $this->result($_SERVER['HTTP_REFERER'],0,'error');
        }
        $this->result($_SERVER['HTTP_REFERER'],1,'success');
    }
    public function test()
    {
        $res = \Map::staticImage('大连市沙河口区软件园3号楼');
        return $res;
    }
}