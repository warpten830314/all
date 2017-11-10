<?php
namespace Common\Model;

use function Sodium\add;
use Think\Model;

class PositionModel extends Model
{
    private $_dbc = '';
    public function __construct()
    {
        parent::__construct();
        $this->_dbc = M('position');
    }
    public function getPositions ()
    {
        $res = $this->_dbc->where('status = 1')->select();
        return $res;
    }
    public function addPositions ($data)
    {
        if (!$data || !is_array($data))
        {
            return 0;
        }
        $res = $this->_dbc->add($data);
        return $res;
    }
    public function deletePositions ($data)
    {
        $dataCon = array(
          'status' => $data['status']
        );
        $res = $this->_dbc->where('id='.$data['id'])->save($dataCon);
        return $res;
    }
    public function getPositionById($id)
    {
        if (!$id || !is_numeric($id))
        {
            return 0;
        };
        $res = $this->_dbc->where('id='.$id)->find();
        return $res;
    }
    public function updatePositionById($id,$data)
    {
        if (!$id || !is_numeric($id))
        {
            return 0;
        }
        $res = $this->_dbc->where('id='.$id)->save($data);
        return $res;
    }

}