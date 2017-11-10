<?php
namespace app\api\controller;

use think\Controller;

class category extends Controller
{
    public function getCategoryByParentId()
    {
        $id = input('post.id');
        $res = model('category')->getAllFirstNormalCategorys($id);
        if (!$res)
        {
            $this->result('',0,'获取失败');
        }
        $this->result($res,1);
    }
}