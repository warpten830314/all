<?php

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        //设置规则
        'status' => 'number',
        'name' => 'require|max:15',
        'parent_id' => 'number',
        'id' => 'number',
        'listorder' => 'number',
    ];
    protected $message = [
        'status.number' => '类型必须为数字',
        'name.requier' => '名字不能为空',
        'name.max' => '长度不能超过15',
        'parent_id.number' => '类型必须为数字',
        'id.number' => '必须是数字',
    ];
    //设置场景
    protected $scene = [
        'add' => ['name','parent_id'],
        'status' => ['status','id'],
        'update' => ['name','id','parent_id'],
        'listorder' => ['listorder','id'],
    ];
}