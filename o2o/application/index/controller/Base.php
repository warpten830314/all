<?php
namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    public $city;
    public $account;
    protected function _initialize()
    {
        //获取城市信息
        $cities = model('City')->getAllseCitys();
        $user = session('o2o_user','','lee');
        $this->account = $user;//赋值给全局对象,在子类可以访问
        //获取head部分应该显示的当前城市
        $city = $this->getCity($cities);
        $recommendArray = $this->getRecommendCategory();
        $this->assign('cities',$cities);
        $this->assign('user',$user);
        $this->assign('city',$city);
        $this->assign('recs',$recommendArray);
        //获取当前控制器名称字符串并返回到首页
        $this->assign('controller',strtolower(request()->controller()));
        //设置title
        $this->assign('title','玖壹壹团购网');
    }
    //获取用户在首页点击的城市
    public function getCity($cities)
    {
        $defaultName = '';
        foreach ($cities as $city)
        {
            $city = $city->toArray();
            if ($city['is_default'] == 1)
            {
                $defaultName = $city['uname'];break;
            }
        }
        $defaultName = $defaultName ? $defaultName : 'dalian';
        if (!input('city') && session('o2o_city','','o2o'))
        {
            $current_city = session('o2o_city','','o2o');
        }
        else if (input('city'))
        {
            $current_city = model('city')->get(['uname'=>input('city')]);
            session('o2o_city',$current_city,'o2o');
        }
        else
        {
            $cityName = input('city',$defaultName,'trim');
            $current_city = model('city')->get(['uname'=>$cityName]);
            session('o2o_city',$current_city,'o2o');
        }
        $this->city = $current_city;
        return $current_city;
    }
    public function getRecommendCategory()
    {
        $categories = model('category')->getCategoryByParentId(0,5);
        $allArray = [];
        foreach ($categories as $category)
        {
            $category = $category->toArray();
            $secArray = [$category['name']];
            $seccategories = model('category')->getCategoryByParentId($category['id']);
            $seccategories = $seccategories ? $seccategories : [];
            $lastArray = [];
            foreach ($seccategories as $seccategory)
            {
                $seccategory = $seccategory->toArray();
                $lastArray[] = ['id' => $seccategory['id'],'name' => $seccategory['name']];
            }
            $secArray[] = $lastArray;
            $allArray[$category['id']] = $secArray;
        }
        return $allArray;
    }
}