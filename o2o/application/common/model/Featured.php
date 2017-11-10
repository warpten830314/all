<?php
namespace app\common\model;

use think\Model;

class Featured extends Model
{
    public function getAllFeatured()
    {
        $data = [
            'status' => ['in', [1,0,-1]]
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate(5);
    }
    public function getFeaturedByType($type = 0)
    {
        $data = [
            'status' => ['in', [1,0,-1]],
            'type' => $type
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate(5);
    }
    //获取所有正常状态的首页推荐位
    public function getAllNormalFeatured($type = 0)
    {
        $data = [
            'status' => 1,
            'type' => $type
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
}