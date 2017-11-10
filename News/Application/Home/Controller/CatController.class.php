<?php
namespace Home\Controller;
use Think\Controller;
class CatController extends Controller
{
    public function index()
    {
        $catId = $_GET['id'];
        if ($catId <= 0 || !$catId)
        {
            $this->error('id不合法');
        }
        $listNews = D('Content')->getNewsByCatId($catId);
        $navs = D('Menu')->getWebsiteMenu();
        $this->assign('navs',$navs);
        //排行下面的中图
        $advNews = D('PositionContent')->getPositionContents($position_id = array('position_id = 5'));
        //右侧排行
        $rankNews = D('Content')->getNewsOrderByCount(0,4);
        //新闻主题列表
        $res = array(
            'advNews' => $advNews,
            'rankNews' => $rankNews,
            'listNews' => $listNews,
            'catId' => $catId
        );
        $this->assign('result',$res);
        $this->display();
    }
    public function error($msg)
    {
        $msg = $msg ? $msg : '系统发生错误';
        $this->assign('message',$msg);
        $this->display('index/error');
    }
}