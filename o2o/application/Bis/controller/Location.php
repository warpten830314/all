<?php
namespace app\bis\controller;


class Location extends Base
{
    private $obj;
    protected function _initialize()
    {
        $this->obj = model('BisLocation');
    }

    public function index()
    {
        $bisID = $this->getLoginUser()->bis_id;
        $locations = model('BisLocation')->getPageinateLocations($bisID);
        return $this->fetch('',[
            'locations' => $locations,
        ]);
    }
    public function add()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            //数据校验
            $validate = validate('Branch');
            $res = $validate->scene('add')->check($data);
            if (!$res)
            {
                $this->error($validate->getError());
            }
            //获取当前用户的bis_id
            $bisID = $this->getLoginUser()->bis_id;
            //准备分类信息字符串
            $se_categories_string = '';
            if (!empty($data['se_category_id']))
            {
                $array = $data['se_category_id'];
                $se_categories_string = ','.implode('|',$array);
            }
            $locationResult = \Map::getLngLat($data['address']);
            if (!$locationResult || $locationResult['result']['precise'] == 0)
            {
                $this->error('地理信息不准确,请重新填写');
            }
            //准备bisLocation表的数据
            $locationData = [
                'name' => $data['name'],
                'logo' => $data['logo'],
                'address' => $data['address'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'xpoint' => empty($locationResult['result']['location']['lng'])? '' : $locationResult['result']['location']['lng'],
                'ypoint' => empty($locationResult['result']['location']['lat'])? '' : $locationResult['result']['location']['lat'],
                'bis_id' => $bisID,
                'open_time' => $data['open_time'],
                'content' => $data['content'],
                'is_main' => 0,
                'api_address' => $data['address'],
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'].','.$data['se_city_id'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'].$se_categories_string,
            ];
            $res = model('BisLocation')->add($locationData);
            if(!$res)
            {
                $this->error('添加失败');
            }
            $this->success('添加成功');
        }
        $cities = model('city')->getNormalCityByParentId();
        $categories = model('category')->getAllFirstNormalCategorys();
        return $this->fetch('',[
            'cities' => $cities,
            'categories' => $categories
        ]);
    }
    public function status()
    {
        //获取数据
        $data = input();
        $result = model('BisLocation')->save(['status'=>$data['status']],['id'=>$data['id']]);
        if (!$result)
        {
            $this->error('更新状态失败');
        }
        $this->success('状态更新成功');
    }
    public function detail()
    {
        $id = input('id',0,'intval');
        $res = $this->obj->get($id);
        $cities = model('city')->getNormalCityByParentId(0);
        $categories = model('category')->getAllFirstNormalCategorys();
        $se_cities = model('city')->getNormalCityByParentId(intval($res['city_id']));
        $se_city_id = $this->getSeCityByCityPath(intval($res['city_path']));
        return $this->fetch('',[
            'locationData' => $res,
            'cities' => $cities,
            'categories' => $categories,
            'se_cities' => $se_cities,
            'se_city_id' => $se_city_id,
        ]);
    }
}