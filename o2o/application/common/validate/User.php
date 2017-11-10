<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username' => 'require|max:30',
        'password' => 'require',
        'email' => 'require|email',
        'verifycode' => 'require',
    ];
    protected $message = [
        'username.require' => '用户名不能为空',
        'username.max' => '用户名长度不能超过30',
        'password.require' => '密码不能为空',
        'email.require' => '邮箱不能为空',
        'email.email' => '邮箱格式错误',
        'verifycode|require' => '请输入验证码',
    ];
    protected $scene = [
        'add' => ['username','password','email'],
        'login' => ['username','password'],
    ];
}