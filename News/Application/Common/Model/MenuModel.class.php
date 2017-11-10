<?php

namespace Common\Model;

use Think\Model;

class MenuModel extends Model
{
    private $_dbc = '';
    public function __construct()
    {
        parent::__construct();
        $this->_dbc = M('menu');
    }
    public function getAdminMenuList()
    {
        $condition = array(
            'status' => array('neq' ,-1),
            'type' => 1
        );
        return $this->_dbc->where($condition)->order('listorder desc, menu_id desc')->select();
    }
    //获取菜单管理内容
    public function getMenuContent ($condition,$pageNum = 0,$pageSize = 3)
    {
        if (!is_numeric($pageNum) || !is_numeric($pageSize))
        {
            return 0;
        }
        if (!is_array($condition))
        {
            return 0;
        }
        if (in_array(intval($condition['type']),array(0,1)) && $condition != null)
        {
            $dataCon['type'] = intval($condition['type']);
        }
        $dataCon['status'] = array('neq',-1);
        $offset = ($pageNum-1)*$pageSize;
        $res = $this->_dbc->where($dataCon)->order('listorder desc , menu_id desc')->limit($offset,$pageSize)->select();
        return $res;
    }
    //获取数据总量
    public function getMenuCount($condition)
    {
        $data = array(
        'status'=>array('neq',-1),
        );
        if (in_array(intval($condition['type']),array(0,1)) && $condition != null)
        {
            $data['type'] = intval($condition['type']);
        };
        return $this->_dbc->where($data)->count();
    }
    public function addMenu ($data)
    {
        if (!$data || !is_array($data))
        {
            return 0;
        }
       $res = $this->_dbc->add($data);
       return $res;
    }
    public function update($data)
    {
        if (!$data || !is_array($data))
        {
            return 0;
        }
        $dataCon = array(
          'status' => $data['status']
        );
        $res = $this->_dbc->where('menu_id='.$data['id'])->save($dataCon);
        return $res;
    }
    public function getMenuByID($menu_id)
    {
        if (!is_numeric($menu_id))
        {
            return 0;
        }
        $res = $this->_dbc->where('menu_id='.$menu_id)->find();
        return $res;
    }
    public function updateMenuById($menu_id,$data)
    {
        if (!is_numeric($menu_id) || !is_array($data))
        {
            return 0;
        }
        $res = $this->_dbc->where('menu_id='.$menu_id)->save($data);
        return $res;
    }
    public function updateListorderById($menu_id,$newListorder)
    {
        if (!is_numeric($menu_id) || !is_numeric($newListorder))
        {
            return 0;
        }
        $data = array(
          'listorder' =>$newListorder
        );
        $res = $this->_dbc->where('menu_id='.$menu_id)->save($data);
        return $res;
    }
    public function getMenuByType($type)
    {
        $res = $this->_dbc->where('type='.$type)->select();
        return $res;
    }
    public function getWebsiteMenu()
    {
        $data=array(
            'status' => 1,
            'type' => 0
        );
        $res = $this->_dbc->where($data)->select();
        return $res;
    }
}