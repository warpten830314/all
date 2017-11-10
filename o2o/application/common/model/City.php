<?php
namespace app\common\model;

use think\Model;

class City extends Model
{
    public function getNormalCityByParentId($parent_id = 0)
    {
        $data = [
            'status' => ['neq',-1],
            'parent_id' => $parent_id
        ];
        $order = [
            'id' => 'asc'
        ];
        return $this->where($data)->order($order)->select();
    }
    public function getAllseCitys()
    {
        $data = [
            'status' => ['neq',-1],
            'parent_id' => ['gt',0],
        ];
        $order = [
            'listorder' =>'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
}