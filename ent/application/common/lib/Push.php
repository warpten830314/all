<?php
namespace app\common\lib;


use think\Controller;

class Push extends Controller
{
    public function push($content, $newId)
    {

        $appKey = '0dd311f676c6fd0a17228c6c';
        $masterSecret = 'eb64ad9d1668dc06aeaa3e8f';

        $client = new Client($appKey,$masterSecret);

        $data = $client->push()
            ->setPlatform('all')  // 推送平台
            ->addAllAudience()   //广播
            ->setNotificationAlert($content) //推送内容
            ->iosNotification('zm'.[
                    'news_id' => $newId
                ])
            ->androidNotification('zm',[
                'news_id' => 2
            ])
            ->send();
    }
}