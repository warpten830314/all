<?php
namespace app\common\model;

use think\Model;

class BisAccount extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data)
    {
        $data['status'] = 0;
        $this->save($data);
        //返回添加成功后的主键id
        return $this->id;
    }
    public function getAccountByUsername($username)
    {
        $data = [
            'username' => $username
        ];
        return $this->where($data)->find();
    }
}