<?php
namespace app\common\model;

use think\Model;

class Category extends Model
{
    public function getAllCategory()
    {
        $data = [
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }
}