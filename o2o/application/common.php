<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//应用公共文件
function status($status)
{
    if ($status == 2)
    {
        return "<label class='label label-danger radius'>拒绝</label>";
    }
    if ($status == 1)
    {
        return "<label class='label label-success radius'>正常</label>";
    }
    if ($status == 0)
    {
        return "<label class='label label-danger radius'>待审</label>";
    }
    if ($status == -1)
    {
        return "<label class='label label-danger radius'>删除</label>";
    }

}
//是否为总店
function ismain($ismain)
{
    if ($ismain == 1)
    {
        return "<label class='label label-success radius'>是</label>";
    }
    else
    {
        return "<label class='label label-primary radius'>否</label>";
    }
}
//设置分页样式的方法
function pageination($pageObj)
{
    if (!$pageObj)
    {
        return '';
    }
    $res = "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>".$pageObj->render()."</div>";
    return $res;
}
//网络请求的方法 : cURL

/**
 * @param $url 请求的url
 * @param int $type 请求的方式 0 get , 1 post
 * @param array $data 请求时的数据 (post)
 */
function doCurl($url, $type = 0, $data = [])
{
    //初始化curl;
    $ch = curl_init();
    //设置相关参数
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    //判断请求方式
    if ($type == 1)
    {
        //post请求
        curl_setopt($ch,CURLOPT_POST, $url);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    }
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}
//判断用户注册状态值
function bisRegister($status)
{
    if ($status == 1)
    {
        $str = '审核通过';
    }
    else if ($status == 0)
    {
        $str = '正在审核中,稍后平台方会向您发送邮件,请关注邮件';
    }
    else if ($status == 2)
    {
        $str = '审核未通过,您提交的材料不符合要求,请重新提交';
    }
    else
    {
        $str = '申请已经被删除';
    }
    return $str;
}
//根据category_path处理二级分类信息
function getCategoryDetailByPath($category_path)
{
    if (empty($category_path))
    {
        return '';
    }
    if (preg_match('/,/',$category_path))
    {
        //先按照,号切割字符串
        $tempArray = explode(',',$category_path);
        $categoryID = $tempArray[0];
        $cateString = $tempArray[1];
        $temp_se_arr = explode('|',$cateString);
        $allCategories = model('Category')->getAllFirstNormalCategorys(intval($categoryID));
        $htmlString = '';
        for ($i = 0 ; $i < count($allCategories) ; $i++)
        {
            $current = $allCategories[$i];
            if (in_array($current['id'],$temp_se_arr))
            {
                $htmlString .= "<input type='checkbox' value='".$current['id']."' checked='checked'>";
                $htmlString .= "<label>".$current['name']."</label>";
            }
            else
            {
                $htmlString .= "<input type='checkbox' value='".$current['id']."'";
                $htmlString .= "<label>".$current['name']."</label>";
            }
        }
        return $htmlString;
    }
    else
    {
        $tempArray = explode(',',$category_path);
        $categoryID = $tempArray[0];
        $allCategories = model('Category')->getAllFirstNormalCategorys(intval($categoryID));
        $htmlString = '';
        for ($i = 0 ; $i < count($allCategories) ; $i++)
        {
            $current = $allCategories[$i];
                $htmlString .= "<input type='checkbox' value='".$current['id']."'";
                $htmlString .= "<label>".$current['name']."</label>";
        }
        return $htmlString;
    }
}
function getCityNameByCityId($city_id)
{
    if (empty($city_id))
    {
        return '';
    }
    $city = model('City')->get($city_id);
    return $city->name;
}
function getCategoryNameByCategoryId($category_id)
{
    if (empty($category_id))
    {
        return '';
    }
    $category = model('Category')->get($category_id);
    return $category->name;
}
function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if(isset($_SERVER['HTTP_X_REAL_IP'])){//nginx 代理模式下，获取客户端真实IP
        $ip=$_SERVER['HTTP_X_REAL_IP'];
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}
//
function countLocation($location)
{
    if (!$location)
    {
        return 1;
    }
    $arr = explode(',',$location);
    return count($arr);
}
function getStartTime($start_time)
{
    $time = intval($start_time);
    $tempTime = $time-time();
    return date('d天H时i分s秒',$tempTime);
}