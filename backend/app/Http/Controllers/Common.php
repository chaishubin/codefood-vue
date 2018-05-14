<?php

namespace App\Http\Controllers;

use Faker\Provider\File;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class Common
 * @package App\Http\Controllers
 * 公共方法类
 */
class Common
{
    /**
     * @param $status
     * @param $msg
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     * 格式化响应json格式的方法
     */
    public static function jsonFormat($status,$msg,$data='')
    {
        if (!$data){
            return response()->json([
                'status' => $status,
                'msg' => $msg,
            ]);
        }
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
    }


    /**
     * @return string
     * 创建20位bigint的id
     */
    public static function createBigIntId()
    {
        $id = time().str_pad(rand(1,999),3,0).str_pad(rand(1,99),2,1);
        return $id;
    }

    /**
     * @param int $relationship_id
     * @return array|int|mixed
     * 与本人关系配置文件
     */
    public static function relationshipWithMe($relationship_id = 0)
    {
        $relationship = [
            '101' => '本人',
            '102' => '家人',
            '103' => '亲属',
            '104' => '朋友',
            '105' => '其他',
        ];
        if ($relationship_id){
            if (!array_key_exists($relationship_id,$relationship)){
                return $relationship_id;
            }
            return $relationship[$relationship_id];
        }

        $data = [];
        foreach ($relationship as $k => $v){
            $data[] = ['id' => $k, 'name' => $v];
        }
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param int $order_status_id
     * @return \Illuminate\Http\JsonResponse|int|mixed
     * 订单状态配置文件
     */
    public static function orderStatus($order_status_id=0)
    {
        $order_status = [
            '101' => '待支付',
            '102' => '已支付',
        ];
        if ($order_status_id){
            if (!array_key_exists($order_status_id,$order_status)){
                return $order_status_id;
            }
            return $order_status[$order_status_id];
        }
        $data = [];
        foreach ($order_status as $k => $v){
            $data[] = ['id' => $k,'name' => $v];
        }
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param int $pay_way_id
     * @return \Illuminate\Http\JsonResponse|int|mixed
     * 支付方式配置文件
     */
    public static function payWay($pay_way_id=0)
    {
        $pay_way = [
            '101' => '微信支付',
            '102' => '支付宝',
            '103' => '银行卡',
        ];
        if ($pay_way_id){
            if (!array_key_exists($pay_way_id,$pay_way)){
                return $pay_way_id;
            }
            return $pay_way[$pay_way_id];
        }
        $data = [];
        foreach ($pay_way as $k => $v){
            $data[] = ['id' => $k,'name' => $v];
        }
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param int $platform_id
     * @return \Illuminate\Http\JsonResponse|int|mixed
     * 选择平台配置文件
     */
    public static function platForm($platform_id=0)
    {
        $platform = [
            '101' => 'APP-医生',
            '102' => 'APP-C端',
            '103' => 'WAP-H5',
        ];
        if ($platform_id){
            if (!array_key_exists($platform_id,$platform)){
                return $platform_id;
            }
            return $platform[$platform_id];
        }
        $data = [];
        foreach ($platform as $k => $v){
            $data[] = ['id' => $k,'name' => $v];
        }
        return Common::jsonFormat('200','获取成功',$data);
    }


    /**
     * @param int $platform_id
     * @return \Illuminate\Http\JsonResponse|int|mixed
     * 商品标签配置文件
     */
    public static function goodsTag($goods_tag_id=0)
    {
        $goods_tag = [
            '101' => '新品',
            '102' => '特价',
            '103' => '满减',
        ];
        if ($goods_tag_id){
            if (!array_key_exists($goods_tag_id,$goods_tag)){
                return $goods_tag_id;
            }
            return $goods_tag[$goods_tag_id];
        }
        $data = [];
        foreach ($goods_tag as $k => $v){
            $data[] = ['id' => $k,'name' => $v];
        }
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param int $banner_position_id
     * @return \Illuminate\Http\JsonResponse|int|mixed
     * banner位置配置文件
     */
    public static function bannerPosition($banner_position_id=0)
    {
        $banner_position = [
            '101' => '首页',
        ];
        if ($banner_position_id){
            if (!array_key_exists($banner_position_id,$banner_position)){
                return $banner_position_id;
            }
            return $banner_position[$banner_position_id];
        }
        $data = [];
        foreach ($banner_position as $k => $v){
            $data[] = ['id' => $k,'name' => $v];
        }
        return Common::jsonFormat('200','获取成功',$data);
    }


    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     * 上传图片
     */
    public function uploadImg(Request $request)
    {
        if ($request->isMethod('POST')){
            $file = $request->file('file');
            if (count($file) > 1){ //多图上传
                $url = [];
                foreach ($file as $k => $v){
                    if ($v->isValid()){
                        $realPath = $v->getRealPath();
                        $tmpName = $v->getFileName();
                        $extName = $v->getClientOriginalExtension();

//                        $fdsk = new Fdfs();
//                        $url[] = $fdsk->upload($realPath,$extName);

                        $filename = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$extName;
                        $url[] = $v->storeAs('uploads',$filename);

                    }else{
                        return Common::jsonFormat('500','图片上传出错,请重试！');
                    }
                }
                if($url && count($url) == count($file)) {
//                    $img_url = [];
//                    foreach ($url as $v){
//                        $img_url[] = $v['url'];
//                    }
//                    return Common::jsonFormat('200','上传成功',$img_url);
                    return Common::jsonFormat('200','上传成功',$url); //调试使用，若使用laravel本身的storeAs方法，其上传成功之后直接返回url，不同于fdfs返回一个包含url的数组
                } else {
                    return Common::jsonFormat('500','上传失败');
                }

            }else{ //单图上传
                if ($file->isValid()){
                    $realPath = $file->getRealPath();
                    $tmpName = $file->getFileName();
                    $extName = $file->getClientOriginalExtension();

//                    $fdsk = new Fdfs();
//                    $url = $fdsk->upload($realPath,$extName);

                    $filename = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$extName;
                    $url = $file->storeAs('uploads',$filename);

                    if($url) {
//                        return Common::jsonFormat('200','上传成功',$url['url']);
                        return Common::jsonFormat('200','上传成功',$url); //调试使用，若使用laravel本身的storeAs方法，其上传成功之后直接返回url，不同于fdfs返回一个包含url的数组
                    } else {
                        return Common::jsonFormat('500','上传失败');
                    }
                }else{
                    return Common::jsonFormat('500','图片上传出错,请重试！');
                }
            }

        }else{
            return Common::jsonFormat('500','Method方法只能为POST');
        }
    }

    /**
     * @param Request $request
     * @return string
     * excel导出
     */
    public function excelExport(Request $request)
    {
        $file_name = date('Y-m-d-H-i-s').'-'.uniqid();
        $overseas = new OverseasController;
        $order_list = $overseas->orderList($request);
        $cell_data = $order_list->original['data'][0];

        $data = ['id','用户id','订单号','商品id','订单金额','定金','优惠券','实付金额','支付方式','下单时间','支付时间','订单状态','病人姓名','关系','性别','生日','电话','邮箱','创建日期','修改日期','用户名','商品名'];
        array_unshift($cell_data,$data);

        Excel::create($file_name, function($excel) use ($cell_data){
            $excel->sheet('sheet1', function($sheet) use ($cell_data){
               $sheet->rows($cell_data);
           });
        })->store('xls');
        return "exports/{$file_name}.xls";
    }

    /**
     * @return array|false|null|string
     * 获取客户端ip
     */
    public static function getClientIp()
    {
        $unknown = 'unknown';
        if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        /*
        处理多层代理的情况
        或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
        */
        if (false !== strpos($ip, ','))
            $ip = reset(explode(',', $ip));
        return ip2long($ip);
    }

    /**
     * @return string
     * 返回默认头像
     */
    public static function defaultHeadImg()
    {
        return '/public/image/user_default.png';
    }


    /**
     * @param bool $upper
     * @param string $hyphen
     * @return string
     * session_key唯一id
     */
    public static function session_key($upper = FALSE, $hyphen = "") {
        $charid = md5(uniqid(mt_rand(), true));
        if ($upper) {
            $charid = strtoupper($charid);
        }
        //$hyphen = chr(45); // "-"
        //$uuid = chr(123)// "{"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        //. chr(125); // "}"
        return $uuid;
    }

    /**
     * @param $data
     * @return string
     * 加密密码
     */
    public static function md5_password($data) {
        //先得到密码的密文
        $data = md5($data);
        //再把密文中的英文母全部转为大写
        $data = strtoupper($data);
        //最后再进行一次MD5运算并返回
        return strtoupper(md5($data));
    }

    /**
     * @param int $length
     * @return string
     * 随机字符串生成（目前只在微信支付统一下单时使用）
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}