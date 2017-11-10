<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class MenuController extends Controller
{
    public function index()
    {
        $data = array();
        if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0,1)))
        {
            $data['type'] = intval($_REQUEST['type']);
            $this->assign('type',$data['type']);
        }
        else
        {
            $this->assign('type',-1);
        }
        $pageSize = 3;
        $pageNum = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        //显示菜单管理首页数据
        $res = D('Menu')->getMenuContent($data,$pageNum,$pageSize);
        //确定页码内容
        $menuCount = D('Menu')->getMenuCount($data);
        $count = ceil($menuCount/$pageSize);
        $this->assign('menus',$res);
        $this->assign('num',$count);
        $this->assign('p',$pageNum);
        $this->display();
    }



    public function search()
    {
        $data = array();
        if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0,1)))
        {
            $data['type'] = intval($_REQUEST['type']);
            $this->assign('type',$data['type']);
        }
        else
        {
            $this->assign('type',-1);
        }
        $pageSize = 3;
        $pageNum = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        //显示菜单管理首页数据
        $res = D('Menu')->getMenuContent($data,$pageNum,$pageSize);
        //确定页码内容
        $menuCount = D('Menu')->getMenuCount($data);
        $count = intval(ceil($menuCount/$pageSize));
        $this->assign('menus',$res);
        $html = $this->fetch('search');
        $data = array(
            'html' => $html,
            'p' => $pageNum,
            'num' => $count
        );
        $this->ajaxReturn($data);
    }





    public function add()
    {
        if ($_POST) {
            if (!$_POST['name'] || !isset($_POST['name']))
            {
                show(0,'菜单名不能为空');
            }
            if (!isset($_POST['type']))
            {
                show(0,'菜单类型不能为空');
            }
            if (!$_POST['m'] || !isset($_POST['m']))
            {
                show(0,'模块名不能为空');
            }
            if (!$_POST['c'] || !isset($_POST['c']))
            {
                show(0,'控制器名不能为空');
            }
            if (!$_POST['f'] || !isset($_POST['f']))
            {
                show(0,'方法名不能为空');
            }
            if (!$_POST['status'] || !isset($_POST['status']))
            {
                show(0,'状态值不能为空');
            }

            $res = D('Menu')->addMenu($_POST);
            if ($res)
            {
                show(1,'添加成功');
            }
            else
            {
                show(0,'添加失败');
            }
        }
        $this->display();
    }
    public function delete()
    {
        if ($_POST)
        {
            $_POST['status'] = -1;
            $res = D('Menu')->update($_POST);
            if ($res)
            {
                show(1,'删除成功');
            }
            show(0,'删除失败');
        }
    }
    public function edit()
    {
        if ($_GET)
        {
            $id = $_GET['id'];
            $res = D('Menu')->getMenuById($id);
            $this->assign('menu',$res);
            $this->display();
        }
    }
    public function update()
    {
        if ($_POST)
        {
            $menu_id = $_POST['id'];
            unset($_POST['id']);
            $res = D('Menu')->updateMenuById($menu_id,$_POST);
            if ($res)
            {
                show(1,'更新成功');
            }
            show(0,'更新失败');
        }
    }
    public function listorder()
    {
        if ($_POST)
        {
            $listorderArray = $_POST['listorder'];
            try
            {
                foreach ($listorderArray as $key => $value)
                {
                    D('Menu')->updateListorderById(intval($key), intval($value));
                }
            }
            catch (Exception $e)
            {
                show(0,$e->getMessage());
            }
            show(1,'更改成功');
        }
    }
}