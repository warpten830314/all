<?php
namespace app\admin\controller;

use think\Controller;

class Featured extends Controller
{
    private $obj;
    protected function _initialize()
    {
        $this->obj = model('Featured');
    }

    public function index()
    {
        $types = config('featured.featured_type');
        if (request()->isPost())
        {
            $type = input('type',0,'intval');
            $res = $this->obj->getFeaturedByType($type);
        }
        else
        {
            $res = $this->obj->getAllFeatured();
            $type = 0;
        }
        return $this->fetch('',[
            'data' => $res,
            'types' => $types,
            'type' => $type,
        ]);
    }
    public function add()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            //校验..

            //
            $res = $this->obj->save($data);
            if (!$res)
            {
                $this->error('添加失败');
            }
            $this->success('添加成功');
        }
        $types = config('featured.featured_type');
        return $this->fetch('', [
                'types' => $types
            ]);
    }
    public function status()
{
    $id = input('id',0,'intval');
    $status = input('status',0,'intval');
    //修改状态
    $res = $this->obj->save(['status'=>$status],['id'=>$id]);
    if (!$res)
    {
        $this->error('状态修改失败');
    }
    $this->success('状态修改成功');
}
}