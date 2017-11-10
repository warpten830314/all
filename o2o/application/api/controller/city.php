<?php
namespace app\api\controller;

use think\Controller;

class city extends Controller
{
    public function getCitysByParentId()
    {
        $id = input('post.id',0,'intval');
        $cities = model('city')->getNormalCityByParentId($id);
        if (!$cities)
        {
            $this->result('',0,'获取失败');
        }
        $this->result($cities,1);
    }
}