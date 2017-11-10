<?php
namespace app\common\Model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;
    public function getCategories($paginate,$parent_id=0)
    {
        $data = [
            'status' => ['neq',-1],
            'parent_id' =>$parent_id
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        if ($paginate)
        {
            return $this->where($data)->order($order)->paginate();
        }
        else
        {
            return $this->where($data)->order($order)->select();
        }
    }
}