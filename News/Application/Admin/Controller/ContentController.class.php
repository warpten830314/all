<?php
namespace Admin\Controller;
use Common\Model\NewsContentModel;
use Think\Controller;
use Think\Exception;

class ContentController extends Controller
{
    public function index()
    {
        $data = array();
        if (isset($_REQUEST['title']) && $_REQUEST['title'])
        {
            $data['title'] = $_REQUEST['title'];
        }
        $catid = $_REQUEST['catid'];
        $res = D('Content')->getNews($data);
        $menu = D('Menu')->getMenuByType(0,1);
        $positions = D('Position')->getPositions();
        $this->assign('positions',$positions);
        $this->assign('news',$res);
        $this->assign('catid',$catid);
        $this->assign('webSiteMenu',$menu);
        $this->assign('title',$data['title']);
        $this->display();

    }
    public function listorder ()
    {
        $listorder = $_POST['listorder'];
        try
        {
            foreach ($listorder as $k => $v)
            {
                D('News')->updateListorderById(intval($k),intval($v));
            }
        }
        catch (Exception $e)
        {
            show(0,$e->getMessage());
        }
        show(1,'更新成功');
    }
    public function push()
    {
        if ($_POST)
        {
            if (!isset($_POST['checked']) || !$_POST['checked'])
            {
                return show(0,['请选择要推送的文章']);
            }
            $news_ids = $_POST['checked'];
            $position = $_POST['position_id'];
            $newsArray = D('News')->getNewsByIdIn($news_ids);
            try
            {
                foreach ($newsArray as $news)
                {
//                    unset($news['small_title']);
//                    unset($news['title_font_color']);
//                    unset($news['keywords']);
//                    unset($news['posids']);
//                    $news['position_id'] = $position;
                    $data  = array(
                        'position_id' => $position,
                        'title' => $news['title'],
                        'news_id' => $news['news_id'],
                        'thumb' => $news['thumb'],
                        'create_time' => $news['create_time'],
                        'status' => $news['status']
                    );

                    D('PositionContent')->addNewNews($data);
                }
            }catch (Exception $e)
            {
                return show(0,$e->getMessage());
            }
            return show(1,'添加成功');
        }
    }
    public function add()
    {
        if ($_POST) {
            if (!isset($_POST['title']) || !$_POST['title'])
            {
                return show(0, '标题不能为空');
            }
            if (!isset($_POST['small_title']) || !$_POST['small_title'])
            {
                return show(0, '短标题不能为空');
            }
            if (!isset($_POST['catid']) || !$_POST['catid'])
            {
                return show(0, '请选择文章栏目');
            }
            if (!isset($_POST['copyfrom'])) {
                return show(0, '请选择文章来源');
            }
            if (!isset($_POST['title_font_color']) || !$_POST['title_font_color']) {
                return show(0, '请选择标题颜色');
            }
            if (!isset($_POST['keywords']) || !$_POST['keywords']) {
                return show(0, '关键字不存在');
            }
            if (!isset($_POST['content']) || !$_POST['content']) {
                return show(0, '内容不存在');
            }
            if (isset($_POST['news_id']) && $_POST['news_id'])
            {
                $news_id = $_POST['news_id'];
                unset($_POST['news_id']);
                $content = $_POST['content'];
                $contentdata['content'] = $content;
                $res1 = D('Content')->updateById($news_id,$_POST);
                if (!$res1)
                {
                    return show(0,'新闻更新失败');
                }
                $res2 = D('NewsContent')->updateById($news_id,$contentdata);
                if (!$res2)
                {
                    return show(0,'内容更新失败');
                }
                return show(1,'更新成功');
            }
            $newsId = D('Content')->insert($_POST);
            if ($newsId)
            {
                $newsContentData['content'] = $_POST['content'];
                $newsContentData['news_id'] = $newsId;
                $cId = D('NewsContent')->insert($newsContentData);
                if ($cId)
                {
                    return show(1, '新增成功');
                }
                else
                {
                    return show(1, '主表插入成功,附表插入失败');
                }
            }
            else
            {
                return show(0, '新增失败');
            }
        }
        $titleFontColor = C('TITLE_FONT_COLOR');
        $this->assign('titleFontColor',$titleFontColor);
        $menus = D('Menu')->getWebsiteMenu();
        $this->assign('webSiteMenu',$menus);
        $copyfrom = C('COPY_FROM');
        $this->assign('copyfrom',$copyfrom);
        $this->display();
    }
    public function delete()
    {
        if ($_POST)
        {
            $news_id = $_POST['id'];
            $res = D('Content')->delete($news_id);
            if ($res)
            {
                return show(1,'删除成功');
            }
            else
            {
                return show(0,'删除失败');
            }
        }
    }
    public function edit()
    {
        if ($_GET)
        {
            $news_id = intval($_GET['id']);
        }
        $res = D('Content')->getNewsById($news_id);
        $content = D('NewsContent')->getNewscontentByNewsId($news_id);
        $res['content'] = $content['content'];
        $this->assign('news',$res);
        $titleFontColor = C('TITLE_FONT_COLOR');
        $this->assign('titleFontColor',$titleFontColor);
        $menus = D('Menu')->getWebsiteMenu();
        $this->assign('webSiteMenu',$menus);
        $copyfrom = C('COPY_FROM');
        $this->assign('copyfrom',$copyfrom);
        $this->display();

    }
}