<?php
namespace app\common\model;

use think\Model;

class BisLocation extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data)
    {
        $data['status'] = 0;
        $this->save($data);
        //返回添加成功后的主键id
        return $this->id;
    }
    public function getAllLocations($bis_id)
    {
        if ($bis_id)
        {
            $data = [
                'status' => ['neq',-1],
                'bis_id' => $bis_id
            ];
            $order = [
                'listorder' => 'desc',
                'id' => 'desc',
            ];
            return $this->where($data)->order($order)->select();
        }
        $data = [
            'status' => ['neq',-1],
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }
    public function getPageinateLocations($bis_id)
    {
        $data = [
            'status' => ['neq',-1],
            'bis_id' => $bis_id
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate(5);
    }
}