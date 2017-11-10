<?php
namespace Common\Model;

use Think\Model;

class UploadImageModel extends Model
{
    private $_uploadObj = ''; //文件上传对象
    private $_uploadImageData = '';
    const UPLOAD = 'upload'; //图片根路径名称
    public function __construct()
    {
        $this->_uploadObj = new \Think\Upload();
        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
        $this->_uploadObj->subName = date(Y).'/'.date(m).'/'.date(d);
    }
    public function imageUpload()
    {
        //调用thinkphp中upload()对象的上传文件方法
        $res = $this->_uploadObj->upload();
        if ($res)
        {
            return '/'.self::UPLOAD.'/'.$res['file']['savepath'].$res['file']['savename'];
        }
        else
        {
            return false;
        }
    }
}