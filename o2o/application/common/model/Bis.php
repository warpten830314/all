<?php
namespace app\common\model;

use think\Model;

class Bis extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data)
    {
        $data['status'] = 0;
        $this->save($data);
        //返回添加成功后的主键id
        return $this->id;
    }
    public function getBisByStatus($status)
    {
        $data = [
            'status' => $status
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->paginate(5);
    }
}