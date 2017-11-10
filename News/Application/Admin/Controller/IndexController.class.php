<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
        if (!session())
        {
            redirect('./admin.php?c=login&a=index');
        }
        $this->display();
    }
}