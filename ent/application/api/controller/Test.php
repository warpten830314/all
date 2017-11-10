<?php
namespace app\api\controller;

use app\common\lib\aliyun;
use app\common\lib\ApiException;
use jpush\src\JPush\Client as JPush;
use aliyun\api_demo\SmsDemo;

class Test extends Common
{
    public function index()
    {
        $data = [
            'signName' => '源文科技',
            'templateCode' => 'SMS_109405011',
            'phoneNumbers' => '13888635791',

        ];
        aliyun::sendmessage();
        SmsDemo::sendSms('源文科技','SMS_109405011','13888635791',Array("code"=>"12345", "product"=>"dsd"));
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
    public function push()
    {
        $client = new JPush('0dd311f676c6fd0a17228c6c','eb64ad9d1668dc06aeaa3e8f');
        $client->push()
            ->setPlatform('all')
            ->addAllAudience()
            ->setNotificationAlert('Hello, JPush')
            ->send();
    }
}