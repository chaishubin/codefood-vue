<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Libs\XML;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 微信支付 - 公众号支付 - 统一下单
     */
    public function wxPay(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'open_id'  => 'required|max:100',
            'order_id' => 'required|numeric',
        ])->validate();

        $order = Order::find($info['order_id']);
        if (!$order){
            return Common::jsonFormat('500','订单信息有误');
        }

        //微信统一下单
        $data = [];
        $data['appid'] = Config('wechat.appid');
        $data['mch_id'] = Config('wechat.mch_id');
        $data['device_info'] = 'WEB';
        $data['nonce_str'] = Common::getNonceStr();
        $data['sign_type'] = 'MD5';
        $data['body'] = '商品简单描述';
        $data['detail'] = '商品详细描述';
        $data['attach'] = '附加数据';
        $data['out_trade_no'] = $info['order_id'];
        $data['fee_type'] = 'CNY';
        $data['total_fee'] = $order['pay_money']*100; // 分
        $data['spbill_create_ip'] = Common::getClientIp();
        $data['time_start'] = date('YmdHis');
        $data['time_expire'] = date('YmdHis',time()+7200);
        $data['notify_url'] = 'https://chunfeng.huobanys.cn/api/overseas/wxNoticePay';

        file_put_contents('log1.txt',$data['notify_url']);

        $data['trade_type'] = 'JSAPI';
        $data['openid'] = $info['open_id'];
        ksort($data);
        $string1 = urldecode(http_build_query($data).'&key='.Config('wechat.pay_key'));
        $data['sign'] = strtoupper(md5($string1));
        $content = XML::build($data);

        $client = new Client(['base_uri'=>'https://api.mch.weixin.qq.com','timeout'=>3.0]);
        $response = $client->request('POST','/pay/unifiedorder',[
            'body' => $content
        ]);

        $data = [];
        if($response->getStatusCode() == 200) {
            $content = $response->getBody();

            $obj_arr = XML::parse($content);
            $data['appId'] = Config('wechat.appid');
            $data['timeStamp'] = time();
            $data['nonceStr'] = Common::getNonceStr();
            $data['package'] = 'prepay_id='.$obj_arr['prepay_id'];
            $data['signType'] = 'MD5';

            ksort($data);
            $string1 = urldecode(http_build_query($data).'&key='.Config('wechat.pay_key'));
            $data['paySign'] = md5($string1);
        }
        return Common::jsonFormat(200,'操作成功',$data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|string
     * 微信支付回调接口
     */
    public function wxNoticePay()
    {
        $data = file_get_contents('php://input');
        $line = $data."\r\n";
        file_put_contents('log2.txt',$line);
        $obj_arr = XML::parse($data);

        $sign = $obj_arr['sign'];
        unset($obj_arr['sign']);
        ksort($obj_arr);
        $string1 = urldecode(http_build_query($obj_arr).'&key='.Config('wechat.pay_key'));
        $cur_sign = strtoupper(MD5($string1));
//以下为$obj_arr的值
//        Array
//        (
//            [appid] => wx6b4184a8ce83463e
//            [attach] => 附加数据
//            [bank_type] => CFT
//            [cash_fee] => 1
//            [device_info] => WEB
//            [fee_type] => CNY
//            [is_subscribe] => Y
//            [mch_id] => 1419730402
//            [nonce_str] => 3idykdhwwc9z9p2k6a70q8ggi0e2toe8
//            [openid] => o5DGTwUNmjGj4ivjAU0iEL_j2zZ8
//            [out_trade_no] => 201804272157055212
//            [result_code] => SUCCESS
//            [return_code] => SUCCESS
//            [time_end] => 20180427215710
//            [total_fee] => 1
//            [trade_type] => JSAPI
//            [transaction_id] => 4200000157201804277557396086
//        )

        if($cur_sign == $sign) {
            // 验证码正确
            // 处理订单业务

            $order = Order::find($obj_arr['out_trade_no']);
            if (!$order){
                return Common::jsonFormat('500','订单信息有误');
            }
            if (($obj_arr['total_fee']/100) == $order['pay_money']){
                $order->order_status = '102'; //已支付
                $order->pay_time = time();
                $order->save();
            }else{
                return Common::jsonFormat('500','实付金额不一致');
            }
        }

        // 返回代码
        $data = [];
        $data['return_code'] = 'SUCCESS';
        $data['return_msg'] = 'OK';
        return XML::build($data);
    }
}
