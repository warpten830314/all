<?php
namespace app\index\controller;

class Detail extends Base
{
    public function index()
    {
        $id = input('id');
        if (!$id)
        {
            $this->error('id非法');
        }
        $deal = model('Deal')->get(['id'=>$id]);
        $shops = $deal->location_ids;
        $shop_ids = explode(',',$shops);
        $data = [];
        foreach ($shop_ids as $shop)
        {
            $data[] = model('Bislocation')->get(intval($shop));
        }
        return $this->fetch('',[
            'title'=>'详情页',
            'detailData' => $deal,
            'location' => $data[0]['xpoint'].','.$data[0]['ypoint'],
        ]);
    }
}