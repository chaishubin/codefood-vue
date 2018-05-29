<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCollection;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 用户注册接口
     */
    public function userRegister(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'name'    => 'nullable|max:100',
            'tel'     => 'required|numeric',
            'email'   => 'nullable',
            'password'=> 'required|confirmed',
            'password_confirmation'=> 'required',
            'icon'    => 'nullable',
            'open_id' => 'nullable',
            'status'  => 'nullable|boolean',
        ])->validate();

        $is_exist = User::where('tel',$info['tel'])->first();
        if ($is_exist){
            return Common::jsonFormat('500','此手机号已经注册');
        }

        try{
            $user = new User;
            $user->id = Common::createBigIntId();
            $user->name = (isset($info['name']) && !empty($info['name'])) ? $info['name'] : '宝宝美食'.rand(1,999);
            $user->tel = $info['tel'];
            $user->email = (isset($info['email']) && !empty($info['email'])) ? $info['email'] : 0;
            $user->password = Common::md5_password($info['password']);
            $user->icon = (isset($info['icon']) && !empty($info['icon'])) ? $info['icon'] : Common::defaultHeadImg();
            $user->open_id = (isset($info['email']) && !empty($info['email'])) ? $info['open_id'] : 0;
            $user->status = (isset($info['status']) && !is_null($info['status'])) ? $info['status'] : 1;;
            $user->session_key = Common::session_key();
            $user->last_login_ip = Common::getClientIp();
            $user->save();

            return Common::jsonFormat('200','注册成功');
        } catch (Exception $e){
            Log::error($e);
            return Common::jsonFormat('500','注册失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 用户登录
     */
    public function userLogin(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'tel' => 'required|numeric',
            'password' => 'required',
        ])->validate();

        //判断手机号是否存在
        $is_exist = User::where('tel',$info['tel'])->first()->toArray();

        if (!$is_exist){
            return Common::jsonFormat('500','账号不存在或密码错误');
        }
        //验证密码正确性
        $md5_password = Common::md5_password($info['password']);
        if ($md5_password != $is_exist['password']){
            return Common::jsonFormat('500','账号不存在或密码错误');
        }

        try{
            $user = User::where('tel',$info['tel'])->first();
            $user->last_login_ip = Common::getClientIp(); //更新登陆ip
            $user->session_key = Common::session_key(); //更新session_key
            $res = $user->save();

            $data = [];
            if ($res){
                $data = User::where('tel',$info['tel'])->first()->toArray();
                $data['password'] = 'xxxx-xxxxx';
                $data['last_login_ip'] = long2ip($data['last_login_ip']);
            }

            return Common::jsonFormat('200','登录成功',$data);
        } catch (Exception $e){
            Log::error($e);
            return Common::jsonFormat('500','登录失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 用户列表
     */
    public function userList(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'name' => 'nullable',
            'tel'  => 'nullable|numeric',
            'open_id' => 'nullable|max:100',
            'status' => 'nullable|boolean',
            'page_num' => 'nullable|integer',
            'length' => 'nullable|integer',
        ])->validate();

        $user_query = User::query();

        if (isset($info['name']) && $info['name']){
            $user_query->where('name','like','%'.$info['name'].'%');
        }
        if (isset($info['tel']) && $info['tel']){
            $user_query->where('tel',$info['tel']);
        }
        if (isset($info['open_id']) && $info['open_id']){
            $user_query->where('open_id',$info['open_id']);
        }
        if (isset($info['status']) && !is_null($info['status'])){
            $user_query->where('status',$info['status']);
        }
        $limit = (isset($info['length']) && !is_null($info['length'])) ? $info['length'] : 10;
        $offset = (isset($info['page_num']) && !is_null($info['page_num'])) ? ($info['page_num']-1)*$limit : 0;

        $total = $user_query->count();
        $user = $user_query->offset($offset)->limit($limit)->orderBy('created_at','desc')->get();

        foreach ($user as $v){
            $v['last_login_ip'] = long2ip($v['last_login_ip']);
            $v['password'] = 'xxxx-xxxx';
        }
        $data = ['total' => $total,'data' => $user];
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 用户信息修改
     */
    public function userModify(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'id' => 'required|numeric',
            'name' => 'nullable',
            'tel' => 'nullable|numeric',
            'password' => 'nullable',
            'password_confirmation' => 'required_with:password|confirmed',
            'email' => 'nullable',
            'icon' => 'nullable',
        ])->validate();

        //判断用户是否存在
        $user = User::find($info['id']);
        if (!$user){
            return Common::jsonFormat('500','此用户不存在');
        }
        $where = [];
        if (isset($info['name']) && $info['name']){
            $where['name'] = $info['name'];
        }
        if (isset($info['tel']) && $info['tel']){
            $where['tel'] = $info['tel'];
        }
        if (isset($info['password']) && $info['password']){
            $where['password'] = $info['password'];
        }
        if (isset($info['email']) && $info['email']){
            $where['email'] = $info['email'];
        }
        if (isset($info['icon']) && $info['icon']){
            $where['icon'] = $info['icon'];
        }

        if (!empty($where)){
            $res = User::where('id',$info['id'])->update($where);
            if ($res){
                return Common::jsonFormat('200','修改成功');
            }else{
                return Common::jsonFormat('500','修改失败');
            }
        }
        return Common::jsonFormat('200','修改成功');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 用户商品收藏列表
     */
    public function userCollectionList(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'user_id' => 'nullable|numeric',
            'goods_id' => 'nullable|numeric',
        ])->validate();

        $data = UserCollection::all();

        return Common::jsonFormat('200','获取成功',$data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 用户商品收藏添加、修改
     */
    public function userCollectionModify(Request $request)
    {
        $info = $request->all();

        if (isset($info['collection_id']) && $info['collection_id']){ //修改用户商品收藏
            Validator::make($info, [
                'collection_id' => 'required|integer',
                'status'        => 'required|integer',
            ])->validate();
            try{
                $collection = UserCollection::find($info['collection_id']);
                $collection->status = $info['status'];
                $collection->save();

                return Common::jsonFormat('200','修改成功');
            } catch (Exception $e){
                Log::error($e);
                return Common::jsonFormat('500','修改失败');
            }
        }else{ //新增用户收藏
            Validator::make($info, [
                'user_id'       => 'required|numeric',
                'goods_id'      => 'required|numeric',
            ])->validate();
            try{
                $collection = new UserCollection;
                $collection->user_id = $info['user_id'];
                $collection->goods_id = $info['goods_id'];
                $collection->status = '1';
                $collection->save();

                return Common::jsonFormat('200','收藏成功');
            } catch (Exception $e){
                Log::error($e);
                return Common::jsonFormat('500','收藏失败');
            }
        }
    }



}
