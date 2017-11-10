<?php
namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    private $obj;
    private $validate;
    protected function _initialize()
    {
        $this->obj = model('Category');
        $this->validate = validate('Category');
    }
    public function index()
    {
        $id = input('parent_id',0,'intval');
        $categories = $this->obj->getCategories(true,$id);
        return $this->fetch('',['categories'=>$categories]);
    }
    public function status()
    {
        $data = [
            'status' => 1-input('status',0,'intval')
        ];
        $where = [
            'id' => input('id',0,'intval')
        ];
        if (!$data)
        {
            return '';
        }
        $res = $this->validate->scene('status')->check($data);
        if (!$res)
        {
            return $this->error($this->validate->getError());
        }
        $res = $this->obj->save($data,$where);
        if (!$res)
        {
            $this->error('更新失败');
        }
        $this->success('更新成功');
    }
    public function edit()
    {
        $id = input('id',0,'intval');
        $category = $this->obj->get($id);
        $categories = $this->obj->getCategories(false);
        return $this->fetch('', ['category' => $category,'categories' => $categories]);
    }
    public function save()
    {
        $data = input('post.');
        $res = $this->obj->save(['name'=>$data['name'],'parent_id'=>$data['parent_id']],['id'=>$data['id']]);
        if (!$res)
        {
            $this->error('更新失败');
        }
        $this->success('更新成功');
    }
    public function listorder()
    {
        $data = input('post.');
        $res = $this->validate->scene('listorder')->check($data);
        if (!$res)
        {
            return $this->error($this->validate->getError());
        }
        $res = $this->obj->save(['listorder'=>$data['listorder']],['id'=>$data['id']]);
        if (!$res)
        {
            return $this->result($_SERVER['HTTP_REFERER'],0,'更新失败');
        }
        return $this->result($_SERVER['HTTP_REFERER'],1,'更新成功');
    }
}