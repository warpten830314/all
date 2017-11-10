<?php
namespace app\api\controller\v1;

use app\api\controller\Common;

class News extends Common
{
    public function index()
    {
        $header = request()->header();
        $catid = $header['catid'];
        $pageoffset = $header['pageoffset'];
        $pagelimit = $header['pagelimit'];
        $data = [
            'condition' => [
                'catid' => $catid
            ],
            'limit' => [
                $pageoffset,
                $pagelimit
            ]
        ];
        $news = model('News')->getNews($data);
        return show(1,'成功',$news,200);
    }
    public function search()
    {
        $header = request()->header();
        $pageoffset = $header['pageoffset'];
        $pagelimit = $header['pagelimit'];
        $title = $header['title'];
        $data = [
            'condition' => [
                'title' => ['like','%'.$title.'%']
            ],
            'limit' => [
                $pageoffset,
                $pagelimit
            ]
        ];
        $news = model('News')->getNews($data);
        return show(1,'成功',$news,200);
    }
}