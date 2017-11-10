<?php
namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\Aliyun;
use app\common\lib\ApiException;

class Test extends Common
{
    public function index()
    {
        $res = Aliyun::getInstance()->setSms('13888635791');
        return 41;
    }
    public function save()
    {
        $data = [
            'df' => 1
        ];
        if ($data['df'] == 1)
        {
            throw new ApiException('数据错误',302);
        }
        return 'API-test-save';
    }
    public function create()
    {
        return 'API-test-create';
    }
    public function read()
    {
        return 'API-test-read'.input('id');
    }
    public function edit()
    {
        return 'API-test-edit'.input('id');
    }
    public function update()
    {
        return 'API-test-update'.input('id');
    }
    public function delete()
    {
        return 'API-test-delete'.input('id');
    }
}