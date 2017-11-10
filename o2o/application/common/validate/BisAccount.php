<?php

namespace  app\common\validate;

use think\Validate;

class  BisAccount extends  Validate
{
    protected $rule =[
        'username' => 'require',
        'password' => 'require',
    ];

    protected  $message=[
        'username.requir' => '用户名不能为空',
        'password.requir' => '密码不能为空',
    ];

    protected $scene =[
        'add'=>[
            'username',
            'password'
        ],
        'login'=>[
            'username',
            'password'
        ]
    ];
}