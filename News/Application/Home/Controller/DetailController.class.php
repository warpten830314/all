<?php
namespace Home\Controller;
use Think\Controller;
class DetailController extends Controller
{
    public function index()
    {
        if ($_GET)
        {
            $news_id = $_GET['id'];
            if ($news_id <= 0 || !$news_id)
            {
                $this->error('id不合法');
            }
            $res['content'] = htmlspecialchars_decode(D('NewsContent')->getNewscontentByNewsId($news_id)['content']);
            $news = D('Content')->getNewsById($news_id);
            $advNews = D('PositionContent')->getPositionContents($position_id = array('position_id = 5'));
            $res['title'] = $news['title'];
            $res['thumb'] = $news['thumb'];
            $rankNews = D('Content')->getNewsOrderByCount(0,4);
            $result = array(
                'rankNews' => $rankNews,
                'news' => $res,
                'advNews' => $advNews
            );
            $navs = D('Menu')->getWebsiteMenu();
            $this->assign('navs',$navs);
            $this->assign('result',$result);
            $this->display();
            $news['count']++;
            $data['count'] = $news['count'];
            D('Content')->updateById($news_id,$data);
        }

    }
    public function error($msg)
    {
        $msg = $msg ? $msg : '系统发生错误';
        $this->assign('message',$msg);
        $this->display('index/error');
    }
}