<?php
namespace app\bis\controller;

class Deal extends Base
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Deal');
    }
    public function index()
    {
        $id = $this->getLoginUser()->bis_id;
        $deal = $this->obj->getAllNormalDeals($id);
        return $this->fetch('',[
            'dealData' => $deal,
        ]);
    }
    public function add()
    {
        $bis_id = $this->getLoginUser()->bis_id;
        if (request()->isPost())
        {
            $data = input('post.');
            $validate = validate('Deal');
            $res = $validate->scene('add')->check($data);
            if (!$res)
            {
                $this->error($validate->getError());
            }
            //准备分类信息字符串
            $se_categories_string = '';
            $se_single_categories_string = '';
            if (!empty($data['se_category_id']))
            {
                $array = $data['se_category_id'];
                $se_single_categories_string = implode(',',$array);
                $se_categories_string = ','.implode('|',$array);
            }
            //准备分店勾选了哪些分店信息的数据
            $locationIds_string = '';
            if (!empty($data['location_ids']))
            {
                $locationIds_string = implode(',',$data['location_ids']);
            }
            $dealData = [
                'name' => $data['name'],
                'city_id' => $data['city_id'],
                'se_city_id' => $data['se_city_id'],
                'city_path' => $data['city_id'].','.$data['se_city_id'],
                'category_id' => $data['category_id'],
                'se_category_id' => $se_single_categories_string,
                'category_path' => $data['category_id'].$se_categories_string,
                'bis_id' => $bis_id,
                'location_ids' => $locationIds_string,
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'total_count' => $data['total_count'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'bis_account_id' => $this->getLoginUser()->id,
                'notes' => $data['notes'],
            ];
            //入库操作
            $res = model('Deal')->save($dealData);
            if (!$res)
            {
                $this->error('添加失败');
            }
            $this->success('添加成功');
        }
        else
        {
            $locations = model('BisLocation')->where(['bis_id'=>$bis_id])->select();
            $cities = model('city')->getNormalCityByParentId(0);
            $categories = model('category')->getAllFirstNormalCategorys();
            return $this->fetch('',[
                'locationData' => $locations,
                'citys' => $cities,
                'categorys' => $categories,
            ]);
        }
    }
    public function edit()
    {
        $id = input('id',0,'intval');
        $res = $this->obj->get(['bis_id' => $id]);
        $locationData = model('bisLocation')->getAllLocations($id);
        $cities = model('city')->getNormalCityByParentId(0);
        $categories = model('category')->getAllFirstNormalCategorys();
        $se_cities = model('city')->getNormalCityByParentId(intval($res['city_id']));
        $se_city_id = $this->getSeCityByCityPath($res['city_path']);
        return $this->fetch('',[
            'dealData' => $res,
            'locationData' => $locationData,
            'citys' => $cities,
            'categorys' => $categories,
            'se_cities' => $se_cities,
            'se_city_id' => $se_city_id,
        ]);
    }
}