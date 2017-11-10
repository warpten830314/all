<?php
namespace app\Bis\controller;

use think\Controller;

class Register extends Controller
{
    public function index()
    {
        //获取城市信息
        $cities = model('City')->getNormalCityByParentId();
        $categories = model('Category')->getAllFirstNormalCategorys();
        return $this->fetch('',[
            'cities' => $cities,
            'categories' => $categories,
        ]);
    }
    public function getSecondCitiesByParentId()
    {
        $id = input('post.id',0,'intval');
        $res = model('City')->getNormalCityByParentId($id);
        if (!$res)
        {
            return $this->result('',0,'失败');
        }
        return $this->result($res,1,'成功');
    }
    public function getCategories()
    {
        $parent_id = input('post.id',0,'intval');
        $res = model('Category')->getAllFirstNormalCategorys($parent_id);
        if (!$res)
        {
            return $this->result('',0,'获取二级分类失败');
        }
        return $this->result($res,1,'success');
    }
    public function regist()
    {
        $data = input('post.','','htmlentities');
        //校验商户数据
        $validateAccount = validate('BisAccount');
        $res = $validateAccount->scene('add')->check($data);
        if (!$res)
        {
            $this->error($validateAccount->getError());
        }
        //验证用户名是否存在
        if (model('BisAccount')->getAccountByUsername($data['username']))
        {
            return $this->error('用户名已存在');
        }
        $validate = validate('Bis');
        $res = $validate->scene('add')->check($data);
        if (!$res)
        {
            $this->error($validate->getError());
        }
        $validateLocation = validate('BisLocation');
        $res = $validateLocation->scene('add')->check($data);
        if (!$res)
        {
            $this->error($validateLocation->getError());
        }
        //判断地理信息为止是否准确
        $locationResult = \Map::getLngLat($data['address']);
        if (!$locationResult || $locationResult['result']['precise'] == 0)
        {
            $this->error('地理信息不准确,请重新填写');
        }
        $bisData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' =>$data['description'],
            'city_id' => $data['city_id'],
            'city_path' => $data['city_id'].','.$data['se_city_id'],
            'bank_info' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
        ];
        //返回添加后的id
        $bisID = model('Bis')->add($bisData);
        //准备分类信息的字符串
        $se_categories_string = '';
        if (!empty($data['se_category_id']))
        {
            $array = $data['se_category_id'];
            $se_categories_string = implode('|',$array);
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
            'is_main' => 1,
            'api_address' => $data['address'],
            'city_id' => $data['city_id'],
            'city_path' => $data['city_id'].','.$data['se_city_id'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'].','.$se_categories_string,
            'bank_info' => $data['bank_info'],
        ];
        $res = model('BisLocation')->add($locationData);
        //随机生成code : 四位整数
        $data['code'] = mt_rand(1000,10000);
        //准备商户信息
        $accountData = [
            'username' => $data['username'],
            'password' => md5($data['password'].$data['code']),
            'code' => $data['code'],
            'bis_id' => $bisID,
            'is_main' => 1
        ];
        //商户信息存入数据库
        $res = model('BisAccount')->add($accountData);
        if (!$res)
        {
            $this->error('申请失败');
        }
        //发送邮件通知
        $title = "商城申请入驻通知";
        $url = request()->domain().url('bis/register/waiting',['id' => $bisID]);
        $content = "您的店铺信息正在审核中,点击<a href='".$url."' target='_blank'>查看状态</a>";
        \phpmailer\Email::send($data['email'],$title,$content);
        $this->success('申请成功',url('register/waiting',['id' => $bisID]));
    }
    public function waiting($id)
    {
        if (empty($id))
        {
            return '';
        }
        //根据id获取Bis信息
        $detial = model('Bis')->get($id);
        return $this->fetch('',['detail' => $detial]);
    }
}