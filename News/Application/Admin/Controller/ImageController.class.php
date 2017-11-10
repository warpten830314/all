<?php
namespace Admin\Controller;

use Think\Controller;

class imageController extends Controller
{
    function ajaxuploadimage()
    {
        $upload = D('UploadImage');
        $res = $upload->imageUpload();
        if ($res == false)
        {
            return show(0,'上传失败');
        }
        else
        {
            return show(1,'上传成功',$res);
        }
    }
}