<?php
namespace Common\Model;


use Think\Model;

class PositionContentModel extends Model
{
    private $_dbc = '';
    public function __construct()
    {
        parent::__construct();
        $this->_dbc = M('position_content');
    }
    public function getPositionContents($data = array())
    {
        $condition = $data;
        if (isset($data['title']) && $data['title'])
        {
            $condition['title'] = array('like','%'.$data['title'].'%');
        }
        $condition['status'] = array('neq',-1);
        $res = $this->_dbc->where($condition)->order('listorder desc ,id desc')->select();
        return $res;
    }
    public function getPositionContentById($id)
    {
        if (!is_numeric($id))
        {
            return 0;
        }
        return $this->_dbc->where('id='.$id)->find();
    }
    //排序
    public function updateListorderById($id,$newlistorder)
    {
        if (!is_numeric($id) || !is_numeric($newlistorder))
        {
            return 0;
        }
        $data['listorder'] = $newlistorder;
        $res = $this->_dbc->where('id='.$id)->save($data);
        return $res;
    }
    public function addNewNews ($data)
    {
        if (!is_array($data) || !$data)
        {
            return 0;
        }
        if (!$data['create_time'])
        {
            $data['create_time'] = time();
        }
        $res = $this->_dbc->add($data);
        return $res;
    }
    public function insert($data = array())
    {
        if (!$data || !is_array($data))
        {
            return 0;
        }
        if (!data['creat_time'])
        {
            $data['creat_time'] = time();
        }
        return $this->_dbc->add($data);
    }
    public function updatePositionContentById($id,$data)
    {
        if (!is_numeric($id))
        {
            return 0;
        }
        if (!$data || !is_array($data))
        {
            return 0;
        }
        return $this->_dbc->where('id='.$id)->save($data);
    }
}