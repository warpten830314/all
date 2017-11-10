<?php
namespace app\index\controller;

use think\Controller;

class Map extends Controller
{
    //llocation 字符串 详细地址或经纬度逗号链接后的字符串
    public function getMapImage($location)
    {
        if (!$location)
        {
            return '';
        }
        return \Map::staticImage($location);
    }
}