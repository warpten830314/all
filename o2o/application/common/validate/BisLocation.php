<?php
namespace app\common\validate;

use think\Validate;

class BisLocation extends Validate
{
    protected $rule =[
        'tel' => 'require',
        'contact' => 'require',
        'open_time' => 'require',
        'content' => 'require',
        'category_id' => 'require',

    ];

    protected  $message=[
        'tel.require' => '联系人电话不能为空',
        'contact.require' => '联系人姓名不能为空',
        'open_time.require' => '营业时间不能为空',
        'content.require' => '内容不能为空',
        'category_id.require' => '请选择分类信息',
    ];

    protected $scene =[
        'add'=>[
            'tel',
            'contant',
            'opentome',
            'content',
            'category_id',
        ]
    ];
}