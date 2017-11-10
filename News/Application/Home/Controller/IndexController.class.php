<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $navs = D('Menu')->getWebsiteMenu();
        $this->assign('navs',$navs);
        //首页大图
        $topPicNews = D('PositionContent')->getPositionContents($position_id = array('position_id = 2'));
        //大图右面的小图
        $topSmallNews = D('PositionContent')->getPositionContents($position_id = array('position_id = 3'));
        //排行下面的中图
        $advNews = D('PositionContent')->getPositionContents($position_id = array('position_id = 5'));
        //右侧排行
        $rankNews = D('Content')->getNewsOrderByCount(0,4);
        //新闻主题列表
        $listNews = D('Content')->getNews();
        for ($i=0;$i<count($topPicNews);$i++)
        {
            $count = D('Content')->getContentById(intval($topPicNews[$i]['news_id']));
            $topPicNews[$i]['count'] = $count['count'];
        }
        $res = array(
            'topPicNews' => $topPicNews,
            'topSmallNews' => $topSmallNews,
            'advNews' => $advNews,
            'rankNews' => $rankNews,
            'listNews' => $listNews
        );
        $this->assign('result',$res);
        $this->display();
    }
}