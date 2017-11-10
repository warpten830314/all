<?php
/**
 * Created by PhpStorm.
 * User: if-information
 * Date: 2017/8/21
 * Time: 下午8:51
 */
namespace Admin\Controller;
use Think\Controller;

class PositionController extends Controller
{
    public function index()
    {
        $res = D('Position')->getPositions();
        $this->assign('positions',$res);
        $this->display();
    }
    public function add()
    {
        if ($_POST)
        {
            if (!$_POST['name'] || isset($_POST['name']))
            {
                show(0,'推荐位名称不能为空');
            }
            if (isset($_POST['status']))
            {
                show(0,'状态不能为空');
            }
            $_POST['create_time'] = time();
            $res = D('Position')->addPositions ($_POST);
            if ($res)
            {
                show(1,'添加成功');
            }
            show(0,'添加失败');
        }
        $this->display();
    }
    public function delete()
    {
        if ($_POST)
        {
            $res = D('Position')->deletePositions ($_POST);
            if ($res)
            {
                show(1,'删除成功');
            }
        }
        show(0,'删除失败');
    }
    public function edit()
    {
        if ($_GET)
        {
            $id = $_GET['id'];
            $res = D('Position')->getPositionById($id);
            $data = array(
                'id'=>$id,
                'name'=>$res['name'],
                'description'=>$res['description'],
            );
            $this->assign('vo',$data);
        }
        if ($_POST)
        {
            $id = $_POST['id'];
            unset($_POST['id']);
            $res = D('Position')->updatePositionById($id,$_POST);
            if ($res)
            {
                show(1,修改成功);
            }
            show(0,'修改失败');
        }
        $this->display();
    }
}