<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositioncontentController extends Controller
{
    public function index()
    {
        $data = array();
        if (isset($_REQUEST['title']) && $_REQUEST['title'])
        {
            $data['title'] = $_REQUEST['title'];
        }
        $position_id = isset($_REQUEST['position_id']) ? $_REQUEST['position_id'] : 2;
        $data['position_id'] = $position_id;
        $res = D('PositionContent')->getPositionContents($data);
        $positions = D('Position')->getPositions();
        $this->assign('positions',$positions);
        $this->assign('contents',$res);
        $this->assign('positionId',$position_id);
        $this->assign('title',$data['title']);
        $this->display();
        if ($_POST)
        {
            $data = array();
            if (isset($_REQUEST['title']) && $_REQUEST['title'])
            {
                $data['title'] = $_REQUEST['title'];
            }
            $position_id = isset($_REQUEST['position_id']) ? $_REQUEST['position_id'] : 2;
            $data['position_id'] = $position_id;
            $res = D('PositionContent')->getPositionContents($data);
            $positions = D('Position')->getPositions();
            $this->assign('positions',$positions);
            $this->assign('contents',$res);
            $this->assign('positionId',$position_id);
            $this->assign('title',$data['title']);
            $this->display('test');
            return 0;
        }
    }
    public function search()
    {
        $data = array();
        if (isset($_REQUEST['title']) && $_REQUEST['title'])
        {
            $data['title'] = $_REQUEST['title'];
        }
        $position_id = isset($_REQUEST['position_id']) ? $_REQUEST['position_id'] : 2;
        $data['position_id'] = $position_id;
        $res = D('PositionContent')->getPositionContents($data);
        $positions = D('Position')->getPositions();
        $this->assign('positions',$positions);
        $this->assign('contents',$res);
        $this->assign('positionId',$position_id);
        $this->assign('title',$data['title']);
        $html = $this->fetch('search');
        $result = array(
            'html' => $html
        );
        $this->ajaxReturn($result);
    }
    public function edit()
    {
        if ($_GET)
        {
            $id = $_GET['id'];
            $positions = D('Position')->getPositions();
            $this->assign('positions',$positions);
            $res = D('PositionContent')->getPositionContentById($id);
            $this->assign('vo',$res);
        }
        if ($_POST)
        {
            $id = $_POST['id'];
            unset($_POST['id']);
            $res = D('PositionContent')->updatePositionContentById($id,$_POST);
            if ($res)
            {
                show(1,'修改成功');
            }
            else
            {
                show(0,'修改失败');
            }
        }
        $this->display();
    }
    public function listorder ()
    {
        $listorder = $_POST['listorder'];
        try
        {
            foreach ($listorder as $k => $v)
            {
                D('PositionContent')->updateListorderById(intval($k),intval($v));
            }
        }
        catch (Exception $e)
        {
            show(0,$e->getMessage());
        }
        show(1,'更新成功');
    }
    public function add()
    {
        if($_POST)
        {
            if (!$_POST['title'])
            {
                show(0,'标题不能为空');
            }
            if (!$_POST['position_id'])
            {
                show(0,'推荐位不能为空');
            }
            if (!isset($_POST['thumb']) || !$_POST['thumb'])
            {
                show(0,'必须上传图片');
            }
            $res = D('PositionContent')->insert($_POST);
            if ($res)
            {
                return show(1,'添加成功');
            }
            return show(0,'添加失败');
        }
        $positions = D('Position')->getPositions();
        $this->assign('positions',$positions);
        $this->display();
    }
}