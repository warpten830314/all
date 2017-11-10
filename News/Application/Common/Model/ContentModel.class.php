<?php
namespace Common\Model;

use Think\Model;

class ContentModel extends Model
{
    protected $tableName = 'News';
    private $_dbc = '';
    public function __construct()
    {
        parent::__construct();

        $this->_dbc = M('news');
    }

    public function getNews($data = array())
    {
        $condition = $data;
        if (isset($data['title']) && $data['title'])
        {
            $condition['title'] = array('like','%'.$data['title'].'%');
        }
        if (!is_array($data))
        {
            return 0;
        }
        if ($data['catid' != ''])
        {
            $condition['catid'] = $data['catid'];
        }
        $condition['status'] = array('neq',-1);
        $res = $this->_dbc->where($condition)->order('listorder desc, news_id desc')->select();
        return $res;

    }
    public function updateListorderById($id,$newlistorder)
    {
        if (!is_numeric($id) || !is_numeric($newlistorder))
        {
            return 0;
        }
        $data['listorder'] = $newlistorder;
        $res = $this->_dbc->where('news_id='.$id)->save($data);
    }
    public function getNewsByIdIn($ids)
    {
        if (!is_array($ids) || !$ids)
        {
            return 0;
        }
        $data = array(
            'news_id' => array('in',implode(',',$ids))
        );
        $res = $this->_dbc->where($data)->select();
        return $res;
    }
    public function insert($data = array())
    {
        if (!is_array($data) || !$data)
        {
            return 0;
        }
        $data['create_time'] = time();
        $data['username'] = getAdminNameToIndex();
        return $this->_dbc->add($data);
    }
    public function delete($id)
    {
        if (!is_numeric($id) || !$id)
        {
            return 0;
        }
        $data['status'] = -1;
        return $this->_dbc->where('news_id='.$id)->save($data);
    }
    public function getNewsById($news_id)
    {
        if (!is_numeric($news_id) || !$news_id)
        {
            return 0;
        }
        return $this->_dbc->where('news_id='.$news_id)->find();
    }
    public function updateById($news_id,$data = array())
    {
        if (!is_numeric($news_id) || !$news_id)
        {
            return 0;
        }
        if (!is_array($data) || !$data)
        {
            return 0;
        }
        $data['update_time'] = time();
        return $this->_dbc->where('news_id='.$news_id)->save($data);
    }
    public function getNewsOrderByCount($fnum,$lnum)
    {
        $fnum = (!is_numeric($fnum) || !$fnum) ? 0 : $fnum;
        $lnum = (!is_numeric($lnum) || !$lnum) ? 1 : $lnum;
        $data = array(
            'status' => array('neq',-1),
        );
        return $this->_dbc->where($data)->order('count desc')->limit($fnum,$lnum)->select();
    }
    public function getContentById($news_id)
    {
        if (!is_numeric($news_id) || !$news_id)
        {
            return 0;
        }
        return $this->_dbc->where('news_id='.$news_id)->field('count')->find();
    }
    public function getNewsByCatId($id)
    {
        if (!is_numeric($id) || !$id)
        {
            return 0;
        }
        return $this->_dbc->where('catid='.$id)->select();
    }
}