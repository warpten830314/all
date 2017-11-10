<?php
namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\ApiException;
use think\Exception;

class Index extends Common
{
    public function index()
    {
        //获取前端传参
        $header = request()->header();
        //前端参数处理
        $position = [];
        $lunbo = intval($header['lunbo']? $header['lunbo'] : 0);
        $position[] = intval($header['positionstar']? $header['positionstar'] : 0);
        $position[] = intval($header['position']? $header['position'] : 0);
        //获取所需数据
        try
        {
            $lunboNews = model('News')->getLunboNewsByLimit($lunbo);
            $positionNews = model('News')->getPositionNewsByLimit($position);
        }catch (Exception $e)
        {
            throw new ApiException('数据库错误',500);
        }
        //添加catname字段
        $lunboNews = $this->getCatname($lunboNews);
        $positionNews = $this->getCatname($positionNews);
        //组合成大数组输出
        $res = [];
        $res['lunbo'] = $lunboNews;
        $res['position'] = $positionNews;
        return show(1,'成功',$res,200);
    }
    public function init()
    {
        $header = request()->header();
        $ver  = $header['version'];
        $data = [
            'condition' => [
                'app_type' => $header['app_type']
            ],
            'limit' => 1
        ];
        $data2 = [
            'condition' => [
                'app_type' => $header['app_type'],
                'version_code' => $ver
            ],
        ];
        $res = model('Version')->getVersion($data)[0];
        $res2 = model('Version')->getVersion($data2)[0];
        if ($res['id'] <= $res2['id'])
        {
            $res['is_update'] = 0;
        }
        else
        {
            $res['is_update'] = $res['is_force']+1;
        }
        $app_active = [
            'app_type' => 'ios',
            'version' => '1.1',
            'did' => 'adasd'
        ];
        model('AppAcitve')->allowField(true)->save($app_active);
        return show(1,'成功',$res,200);
    }
}