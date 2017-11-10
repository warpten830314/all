<?php
namespace app\index\controller;

class Index extends Base
{
    public function index()
    {
        $featuredBig = model('Featured')->getAllNormalFeatured(0);
        //获取首页商品列表数据  美食栏目
        $foodData = model('Deal')->getNormalDealByCategoryId(1,10,$this->city->id);
        //查询美食栏目下的四个子分类
        $food_seData = model('Category')->getCategoryByParentId(1,4);
        return $this->fetch('',[
            'featuredBig' => $featuredBig,
            'foodData' => $foodData,
            'food_seData' => $food_seData,
        ]);
    }
}
