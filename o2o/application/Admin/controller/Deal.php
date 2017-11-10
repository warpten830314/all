<?php
namespace app\admin\controller;

use think\Controller;

class Deal extends Controller
{
    private $obj;
    protected function _initialize()
    {
        $this->obj = model('Deal');
    }

    public function index()
    {
        $data = input('post.');
        $con_data = [];
        if (empty($data))
        {
            $data = [
                'category_id' => 0,
                'city_id' => 0,
                'start_time' => '',
                'end_time' => '',
                'name' => '',
                'status' => 3
            ];
        }
        if (in_array($data['status'],[-1,0,1,2]))
        {
            $con_data['status'] = $data['status'];
        }
        if (!empty($data['category_id']))
        {
            $con_data['category_id'] = $data['category_id'];
        }
        if (!empty($data['city_id']))
        {
            $con_data['se_city_id'] = $data['city_id'];
        }
        if (!empty($data['start_time']))
        {
            $con_data['start_time'] = ['gt',strtotime($data['start_time'])];
        }
        if (!empty($data['end_time']))
        {
            $con_data['end_time'] = ['gt',strtotime($data['end_time'])];
        }
        if (!empty($data['start_time']) && !empty($data['end_time']))
        {
            if (strtotime($data['start_time']) > strtotime($data['end_time']))
            {
                $con_data['start_time'] = ['gt',strtotime($data['end_time'])];
                $con_data['end_time'] = ['lt',strtotime($data['start_time'])];
                $temp = $data['start_time'];
                $data['start_time'] = $data['end_time'];
                $data['end_time'] = $temp;
            }
        }
        if (!empty($data['name']))
        {
            $con_data['name'] = [
                'like' , '%'.$data['name'].'%'
            ];
        }
        //查询deal显示信息
        $deals = $this->obj->getDealsCondition($con_data);
        //获取分类信息
        $categories = model('Category')->getAllFirstNormalCategorys();
        //获取城市信息
        $se_citys = model('City')->getAllseCitys();
        $status = [-1,0,1,2];
        return $this->fetch('',[
            'deals' => $deals,
            'categories' => $categories,
            'se_cities' => $se_citys,
            'data' => $data,
            'status' => $status,
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
    //商户团购商品审核
    public function verify()
    {
        $data = input('post.');
        $con_data = [];
        if (empty($data))
        {
            $data = [
                'category_id' => 0,
                'city_id' => 0,
                'start_time' => '',
                'end_time' => '',
                'name' => '',
                'status' => 3
            ];
        }
        if (in_array($data['status'],[0,1]))
        {
            $con_data['status'] = $data['status'];
        }
        if (!empty($data['category_id']))
        {
            $con_data['category_id'] = $data['category_id'];
        }
        if (!empty($data['city_id']))
        {
            $con_data['se_city_id'] = $data['city_id'];
        }
        if (!empty($data['start_time']))
        {
            $con_data['start_time'] = ['gt',strtotime($data['start_time'])];
        }
        if (!empty($data['end_time']))
        {
            $con_data['end_time'] = ['gt',strtotime($data['end_time'])];
        }
        if (!empty($data['start_time']) && !empty($data['end_time']))
        {
            if (strtotime($data['start_time']) > strtotime($data['end_time']))
            {
                $con_data['start_time'] = ['gt',strtotime($data['end_time'])];
                $con_data['end_time'] = ['lt',strtotime($data['start_time'])];
                $temp = $data['start_time'];
                $data['start_time'] = $data['end_time'];
                $data['end_time'] = $temp;
            }
        }
        if (!empty($data['name']))
        {
            $con_data['name'] = [
                'like' , '%'.$data['name'].'%'
            ];
        }
        $status = [0,1];
        $con_data['status'] = ['in',[1,0]];
        //查询deal显示信息
        $deals = $this->obj->getDealsCondition($con_data);
        //获取分类信息
        $categories = model('Category')->getAllFirstNormalCategorys();
        //获取城市信息
        $se_citys = model('City')->getAllseCitys();
        return $this->fetch('',[
            'deals' => $deals,
            'categories' => $categories,
            'se_cities' => $se_citys,
            'data' => $data,
            'status' => $status,
        ]);
    }
}