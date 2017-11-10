<?php
namespace app\common\model;

use think\Model;

class Deal extends Model
{
    public function getAllNormalDeals($bis_id)
    {
        $data = [
            'status' => ['neq',-1],
            'bis_id' => $bis_id
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->paginate(5);
    }
    public function getDealsCondition($data= [])
    {
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->paginate();
    }
    //根据分类id和数目查询首页的商品数据
    public function getNormalDealByCategoryId($category_id,$limit = 10,$city_id)
    {
        $data = [
            'se_city_id' => $city_id,
            'category_id' => $category_id,
            'status' => 1,
            'start_time' => ['lt',time()],
            'end_time' => ['gt',time()],
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $res = $this->where($data)->order($order);
        if ($limit > 0)
        {
            $res = $res->limit($limit);
        }
        return $res->select();
    }
}