<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class SellerController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商家列表
     */
    public function sellerList(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'user_mobile' => 'nullable|numeric',
            'username' => 'nullable',
            'shop_name' => 'nullable',
            'status' => 'nullable|boolean',
            'page' => 'nullable|integer',
            'length' => 'nullable|integer',
        ])->validate();

        $seller_query = Seller::query();
        if (isset($info['user_mobile']) && $info['user_mobile']){
            $seller_query->where('user_mobile',$info['user_mobile']);
        }
        if (isset($info['username']) && $info['username']){
            $seller_query->where('username','like','%'.$info['username'].'%');
        }
        if (isset($info['shop_name']) && $info['shop_name']){
            $seller_query->where('shop_name','like','%'.$info['shop_name'].'%');
        }
        if (isset($info['status']) && !is_null($info['status'])){
            $seller_query->where('status',$info['status']);
        }

        $limit = (isset($info['length']) && $info['length']) ? $info['length'] : 10;
        $offset = (isset($info['page']) && $info['page']) ? ($info['page']-1)*$limit : 0;

        $seller = $seller_query->orderBy('created_at','desc')->offset($offset)->limit($limit)->get()->toArray();

        foreach ($seller as $k => $v){
            $seller[$k]['password'] = 'xxx-xxxx';
        }

        $total = $seller_query->count();

        $data = ['total'=>$total,$seller];
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商家注册
     */
    public function sellerRegister(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'user_mobile' => 'required|numeric',
            'username'    => 'required',
            'password'    => 'required|confirmed',
            'password_confirmation' => 'required',
            'address'     => 'required',
            'shop_name'   => 'required|max:100',
            'shop_logo'   => 'required',
            'status'      => 'required|boolean',
        ])->validate();

        $is_exist = Seller::where('user_mobile',$info['user_mobile'])->first();
        if ($is_exist){
            return Common::jsonFormat('500','此手机号已经注册');
        }

        try{
            $seller = new Seller;
            $seller->id = Common::createBigIntId();
            $seller->session_key = Common::session_key();
            $seller->user_mobile = $info['user_mobile'];
            $seller->username = $info['username'];
            $seller->password = Common::md5_password($info['password']);
            $seller->address = $info['address'];
            $seller->shop_name = $info['shop_name'];
            $seller->shop_logo = $info['shop_logo'];
            $seller->status = $info['status'];
            $seller->save();

            return Common::jsonFormat('200','注册成功');

        } catch (Exception $e){
            Log::error($e);
            return Common::jsonFormat('500','注册失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商户登录
     */
    public function sellerLogin(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'user_mobile' => 'required|numeric',
            'password' => 'required',
        ])->validate();

        $seller = Seller::where('user_mobile',$info['user_mobile'])->first();
        if (!$seller){
            return Common::jsonFormat('500','手机号不存在或密码错误');
        }
        $seller->toArray();
        if ($info['password'] != $seller['password']){
            return Common::jsonFormat('500','手机号不存在或密码错误');
        }
        //修改session_key
        $seller->session_key = Common::session_key();
        $res = $seller->save();
        $data = Seller::find($seller['id']);
        $data['password'] = 'xxx-xxxx';
        if ($res){
            return Common::jsonFormat('200','登录成功',$data);
        }else{
            return Common::jsonFormat('500','登录失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改商家信息
     */
    public function sellerModify(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'id'          => 'required|numeric',
            'user_mobile' => 'nullable|numeric',
            'username'    => 'nullable',
            'password'    => 'nullable|confired',
            'password_confirmation'    => 'nullable',
            'address'     => 'nullable',
            'shop_name'   => 'nullable|max:100',
            'shop_logo'   => 'nullable',
            'status'      => 'nullable|integer',
        ])->validate();

        $seller = Seller::find($info['id']);
        if (!$seller){
            return Common::jsonFormat('500','不存在此用户');
        }

        if (isset($info['user_mobile']) && $info['user_mobile']){
            $seller->user_mobile = $info['user_mobile'];
        }
        if (isset($info['username']) && $info['username']){
            $seller->username = $info['username'];
        }
        if (isset($info['password']) && $info['password']){
            $seller->user_mobile = Common::md5_password($info['password']);
        }
        if (isset($info['address']) && $info['address']){
            $seller->address = $info['address'];
        }
        if (isset($info['shop_name']) && $info['shop_name']){
            $seller->shop_name = $info['shop_name'];
        }
        if (isset($info['shop_logo']) && $info['shop_logo']){
            $seller->shop_logo = $info['shop_logo'];
        }
        if (isset($info['status']) && !is_null($info['status'])){
            $seller->status = $info['status'];
        }
        $res = $seller->save();

        if ($res){
            return Common::jsonFormat('200','修改成功');
        }else{
            return Common::jsonFormat('500','修改失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商家详情
     */
    public function sellerDetail(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'id'   => 'required|numeric',
        ])->validate();

        $seller = Seller::find($info['id']);
        if (!$seller){
            return Common::jsonFormat('500','不存在此商户');
        }
        $seller['password'] = '';

        return Common::jsonFormat('200','获取成功',$seller);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商家删除
     */
    public function sellerDelete(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'id'   => 'required|numeric',
        ])->validate();

        $seller = Seller::find($info['id']);
        if (!$seller){
            return Common::jsonFormat('500','不存在此商户');
        }
        $res = Seller::where('id',$info['id'])->delete();
        if ($res){
            return Common::jsonFormat('200','删除成功',$seller);
        }else{
            return Common::jsonFormat('200','删除失败',$seller);
        }


    }
}
