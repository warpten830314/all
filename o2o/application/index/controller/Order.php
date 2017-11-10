<?php
namespace app\index\controller;

class Order extends Base
{
    public function index()
    {
        $id = input('id',0,'intval');
        $deal = model('Deal')->get($id);
        //订单号规则: 10位的时间戳+用户id+4位随机数

        return $this->fetch('',[
            'title' => '订单确认页',
            'controller' => 'pay',
            'deal' => $deal,
        ]);
    }
    public function orderconfirm()
    {
        $data = input('post.');
        $deal = model('Deal')->get(intval($data['id']));
        $order_data = [
            'trade_id' => time().$this->account->id.mt_rand(1000,10000),
            'user_id' => $this->account->id,
            'deal_id' => $data['id'],
            'description' => $deal->description,
            'last_id' => get_client_ip(),
            'bis_id' => $deal->bis_id,
            'buy_count' => $data['buy_count'],
            'total_price' => $data['total_price'],
        ];
        //存入数据库
        $res = model('Order')->save($order_data);
        if (!$res)
        {
            $this->error('订单生成失败');
        }
        else
        {
            //前往支付页面 引入支付宝接口
            //构建支付参数
            $payData = [
                'out_trade_no' => $order_data['trade_id'],
                'subject' => 'aaaa',
                'total_amount' => $order_data['total_price']
            ];
            \alipay\Pagepay::pay($payData);
        }
    }
    //return_url 提供给支付宝的用来支付后的跳转的地址,不能百分百保证显示出来
    public function finish()
    {
        if (!empty($_GET))
        {
            //订单号
            $trade_id = $_GET['out_trade_no'];
            //更新订单状态
            $res = model('Order')->save(['status'=>1],['trade_id'=>$trade_id]);
            if (!$res)
            {
                $this->error('订单更新失败');
            }
            else
            {
                $this->success('订单更新成功',url('index/index'),'',1);
            }
        }
    }
}