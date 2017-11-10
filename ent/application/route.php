<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];*/

use think\Route;

//Route::rule('test','api/test/index','GET');
//Route::rule('test','api/test/save','POST');
Route::resource('test','api/test');
Route::resource(':ver/test','api/:ver.test');
Route::resource(':ver/index','api/:ver.index');
Route::resource(':ver/news','api/:ver.news');
Route::get('time','api/time/index');
Route::get(':ver/search','api/:ver.news/search');
Route::get(':ver/init','api/:ver.index/init');
Route::get('push','api/test/push');


Route::resource(':ver/sendcode','api/:ver.SendCode');
Route::resource(':ver/login','api/:ver.Login');