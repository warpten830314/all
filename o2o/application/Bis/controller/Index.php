<?php
namespace app\Bis\controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}
