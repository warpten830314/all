<?php
/**
 * Created by PhpStorm.
 * User: if-information
 * Date: 2017/8/21
 * Time: 下午8:10
 */
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model
{
    private $_dbc = '';
    function __construct()
    {
        $this->_dbc = M('admin');
    }
    public function getAdminName($username)
    {
        $res = $this->_dbc->where("username = '$username'")->find();
        return $res;
    }


}