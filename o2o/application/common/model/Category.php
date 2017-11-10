<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;
    //获取所有一级分类
    public function getFirstNormalCategorys($parent_id=0)
    {
        //条件
        $data = [
            'status' => ['neq', -1],
            'parent_id' => $parent_id
        ];
        $order = [
            'listorder' =>'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->paginate();
    }
    public function getAllFirstNormalCategorys($parent_id = 0)
    {
        //条件
        $data = [
            'status' => ['neq', -1],
            'parent_id' => $parent_id,
        ];
        $order = [
            'listorder' =>'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
    public function getCategoryByParentId($parent_id,$limit = 0)
    {
        $data = [
            'status' => 1,
            'parent_id' => $parent_id,
        ];
        $order = [
            'listorder' =>'desc',
            'id' => 'desc'
        ];
        $res =  $this->where($data)->order($order);
        if ($limit)
        {
            $res = $res->limit($limit);
        }
        return $res->select();
    }
    public function getSeCatsByParentIds($parent_id = [])
    {
        $data = [
            'status' => 1,
            'parent_id' => ['in',implode(',',$parent_id)]
        ];
        $order = [
            'listorder' =>'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
}