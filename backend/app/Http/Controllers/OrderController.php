<?php

namespace App\Http\Controllers;

use App\Models\Order;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 订单列表
     */
    public function orderList(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [

        ])->validate();

        $order = Order::all();
        foreach ($order as $v){
            $v['order_time'] = date('Y-m-d H:i:s',$v['order_time']);
            $v['pay_time'] = date('Y-m-d H:i:s',$v['pay_time']);
        }
        $total = Order::count();
        $data = ['total'=>$total,$order];
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 提交订单
     */
    public function orderAdd(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'user_id'        => 'required|numeric',
            'goods_id'       => 'required|numeric',
            'order_money'    => 'required|numeric',
            'coupon'         => 'required|numeric',
            'pay_money'      => 'nullable|numeric',
            'pay_way'        => 'required|integer',
            'order_time'     => 'nullable',
            'pay_time'       => 'nullable',
            'order_status'   => 'nullable',
        ])->validate();

        $order = new Order;
        $order->id = Common::createBigIntId();
        $order->user_id = $info['user_id'];
        $order->goods_id = $info['goods_id'];
        $order->order_money = $info['order_money'];
        $order->coupon = $info['coupon'];
        $order->pay_money = 0;
        $order->pay_way = $info['pay_way'];
        $order->order_time = time();
        $order->pay_time = 0;
        $order->order_status = '101';
        $res = $order->save();

        if ($res){
            return Common::jsonFormat('200','添加成功');
        }else{
            Log::error();
            return Common::jsonFormat('500','添加失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 订单修改
     */
    public function orderModify(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'order_id' => 'required|numeric',
        ])->validate();

        $data['pay_money'] = $info['pay_money'];
        $data['pay_time'] = time();
        $data['order_status'] = '102';

        $res = Order::where('id',$info['order_id'])->update($data);

        if ($res){
            return Common::jsonFormat('200','修改成功');
        }else{
            return Common::jsonFormat('500','修改失败');
        }
    }

    public function serve()
    {
        $app = Factory::payment(config('wechat.payment'));

        $result = $app->order->unify([
            'body' => '腾讯充值中心-QQ会员充值',
            'out_trade_no' => '20150806125346',
            'total_fee' => 88,
//            'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'notify_url' => 'http://wxpay.wxutil.com/pub_v2/pay/notify.v2.php', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'JSAPI',
            'openid' => 'oUpF8uMuAJO_M2pxb1Q9zNjWeS6o',
        ]);

        return $result;

    }
}
