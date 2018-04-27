<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\GoodsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class GoodsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商品分类列表接口
     */
    public function goodsCategoryList(Request $request)
    {
        $info = $request->all();

        $category_query = GoodsCategory::query();

        if (isset($info['parent_id']) && !is_null($info['parent_id'])){
            $category_query->where('parent_id',$info['parent_id']);
        }
        if (isset($info['seller_id']) && !is_null($info['seller_id'])){
            $category_query->where('seller_id',$info['seller_id']);
        }


        $category = $category_query->orderBy('sort','asc')->get();
        $data = $category;
        return Common::jsonFormat('200','获取成功',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商品分类添加\修改
     */
    public function goodsCategoryModify(Request $request)
    {
        $info = $request->all();

        if (isset($info['category_id']) && !is_null($info['category_id'])){ //修改分类
            Validator::make($info, [
                'category_id'   => 'required|numeric',
                'parent_id'     => 'nullable|numeric',
                'seller_id'     => 'nullable|numeric',
                'category_name' => 'nullable',
                'category_img'  => 'nullable',
                'status'        => 'nullable|integer',
                'sort'          => 'nullable|integer|max:128',
            ])->validate();

            $modify_info = [];
            $category = GoodsCategory::find($info['category_id']);
            if (!$category){
                return Common::jsonFormat('500','不存在此商品');
            }

            if (isset($info['parent_id']) && !is_null($info['parent_id'])){
                $modify_info['parent_id'] = $info['parent_id'];
                $modify_info['parent_id_path'] = $info['parent_id'].'_'.$info['category_id'];
            }
            if (isset($info['seller_id']) && !is_null($info['seller_id'])){
                $modify_info['seller_id'] = $info['seller_id'];
            }
            if (isset($info['category_name']) && !is_null($info['category_name'])){
                $modify_info['category_name'] = $info['category_name'];
            }
            if (isset($info['category_img']) && !is_null($info['category_img'])){
                $modify_info['category_img'] = $info['category_img'];
            }
            if (isset($info['status']) && !is_null($info['status'])){
                $modify_info['status'] = $info['status'];
            }
            if (isset($info['sort']) && !is_null($info['sort'])){
                $modify_info['sort'] = $info['sort'];
            }

            if (!empty($modify_info)){
                $res = GoodsCategory::where('category_id',$info['category_id'])->update($modify_info);

                if ($res){
                    return Common::jsonFormat('200','修改成功');
                }else{
                    return Common::jsonFormat('500','修改失败');
                }
            }
            return Common::jsonFormat('200','修改成功');

        }else{ //添加分类
            Validator::make($info, [
                'parent_id'     => 'required|numeric',
                'seller_id'     => 'required|numeric',
                'category_name' => 'required',
                'category_img'  => 'required',
                'status'        => 'required|integer',
                'sort'          => 'required|integer|max:128',
            ])->validate();
            try{
                $category = new GoodsCategory;
                $category_id = $category->category_id = Common::createBigIntId();
                $parent_id = $category->parent_id = $info['parent_id'];
                $category->parent_id_path = $parent_id.'_'.$category_id;
                $category->seller_id = $info['seller_id'];
                $category->category_name = $info['category_name'];
                $category->category_img = $info['category_img'];
                $category->status = $info['status'];
                $category->sort = $info['sort'];
                $category->save();

                return Common::jsonFormat('200','添加成功');
            } catch (Exception $e){
                Log::error($e);
                return Common::jsonFormat('500','添加失败');
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商品分类删除
     */
    public function goodsCategoryDelete(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'category_id'   => 'required|numeric',
        ])->validate();

        $category = GoodsCategory::find($info['category_id']);
        if (!$category){
            return Common::jsonFormat('500','不存在此分类');
        }

        $res = GoodsCategory::where('category_id',$info['category_id'])->delete();
        if ($res){
            return Common::jsonFormat('200','删除成功');
        }else{
            return Common::jsonFormat('500','删除失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商品列表
     */
    public function goodsList(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'category_id'   => 'nullable|numeric',
            'goods_name'    => 'nullable',
            'goods_tag'     => 'nullable|numeric',
            'status'        => 'nullable|integer',
            'is_hot'        => 'nullable|boolean',
            'offset'        => 'nullable|boolean',
            'limit'        => 'nullable|boolean',
        ])->validate();

        $limit = (isset($info['limit']) && !is_null($info['limit'])) ? $info['limit'] : 10;
        $offset = (isset($info['offset']) && !is_null($info['offset'])) ? ($info['offset']-1)*$limit : 0;

        $goods_query = Goods::query();

        if (isset($info['category_id']) && !is_null($info['category_id'])){
            $goods_query = $goods_query->where('category_id',$info['category_id']);
        }
        if (isset($info['goods_name']) && !is_null($info['goods_name'])){
            $goods_query = $goods_query->where(['goods_name','like','%'.$info['goods_name'].'%']);
        }
        if (isset($info['goods_tag']) && !is_null($info['goods_tag'])){
            $goods_query = $goods_query->where('goods_tag',$info['goods_tag']);
        }
        if (isset($info['status']) && !is_null($info['status'])){
            $goods_query = $goods_query->where('status',$info['status']);
        }
        if (isset($info['is_hot']) && !is_null($info['is_hot'])){
            $goods_query = $goods_query->where('is_hot',$info['is_hot']);
        }

        $goods = $goods_query->offset($offset)->limit($limit)->orderBy('sort','asc')->get()->toArray();
        $total = $goods_query->count();
        $data = ['total' => $total,$goods];

        return Common::jsonFormat('200','获取成功',$data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 添加\修改商品
     */
    public function goodsModify(Request $request)
    {
        $info = $request->all();

        if (isset($info['goods_id']) && !is_null($info['goods_id'])){ //修改商品
            Validator::make($info, [
                'goods_id'      => 'required|numeric',
                'category_id'   => 'nullable|numeric',
                'goods_name'    => 'nullable',
                'goods_summary' => 'nullable',
                'sell_price'    => 'nullable|numeric',
                'goods_tag'     => 'nullable|numeric',
                'status'        => 'nullable|integer',
                'is_hot'        => 'nullable|boolean',
                'sort'          => 'nullable|integer',
                'share_title'   => 'nullable',
                'share_content' => 'nullable',
                'goods_desc'    => 'nullable',
                'goods_img'     => 'nullable',
            ])->validate();

            $goods = Goods::find($info['goods_id']);
            if (!$goods){
                return Common::jsonFormat('500','此商品不存在');
            }

            $goods_modify = [];
            if (isset($info['category_id']) && !is_null($info['category_id'])){
                $goods_modify['category_id'] = $info['category_id'];
            }
            if (isset($info['goods_name']) && !is_null($info['goods_name'])){
                $goods_modify['goods_name'] = $info['goods_name'];
            }
            if (isset($info['goods_summary']) && !is_null($info['goods_summary'])){
                $goods_modify['goods_summary'] = $info['goods_summary'];
            }
            if (isset($info['sell_price']) && !is_null($info['sell_price'])){
                $goods_modify['sell_price'] = $info['sell_price'];
            }
            if (isset($info['goods_tag']) && !is_null($info['goods_tag'])){
                $goods_modifyx['goods_tag'] = $info['goods_tag'];
            }
            if (isset($info['status']) && !is_null($info['status'])){
                $goods_modify['status'] = $info['status'];
            }
            if (isset($info['is_hot']) && !is_null($info['is_hot'])){
                $goods_modify['is_hot'] = $info['is_hot'];
            }
            if (isset($info['sort']) && !is_null($info['sort'])){
                $goods_modify['sort'] = $info['sort'];
            }
            if (isset($info['share_title']) && !is_null($info['share_title'])){
                $goods_modify['share_title'] = $info['share_title'];
            }
            if (isset($info['share_content']) && !is_null($info['share_content'])){
                $goods_modify['share_content'] = $info['share_content'];
            }
            if (isset($info['goods_desc']) && !is_null($info['goods_desc'])){
                $goods_modify['goods_desc'] = $info['goods_desc'];
            }
            if (isset($info['goods_img']) && !is_null($info['goods_img'])){
                $goods_modify['goods_img'] = $info['goods_img'];
            }

            if (!empty($goods_modify)){
                $res = Goods::where('goods_id',$info['goods_id'])->update($goods_modify);
                if ($res){
                    return Common::jsonFormat('200','修改成功');
                }else{
                    return Common::jsonFormat('500','修改失败');
                }
            }
            return Common::jsonFormat('200','修改成功');

        }else{ //添加商品
            Validator::make($info, [
                'category_id'   => 'required|numeric',
                'goods_name'    => 'required',
                'goods_summary' => 'required',
                'sell_price'    => 'required|numeric',
                'goods_tag'     => 'required|numeric',
                'status'        => 'required|integer',
                'is_hot'        => 'required|boolean',
                'sort'          => 'required|integer',
                'share_title'   => 'required',
                'share_content' => 'required',
                'goods_desc'    => 'required',
                'goods_img'     => 'required',
            ])->validate();

            try{
                $goods = new Goods;
                $goods->goods_id = Common::createBigIntId();
                $goods->category_id = $info['category_id'];
                $goods->goods_name = $info['goods_name'];
                $goods->goods_summary = $info['goods_summary'];
                $goods->sell_price = $info['sell_price'];
                $goods->goods_tag = $info['goods_tag'];
                $goods->status = $info['status'];
                $goods->is_hot = $info['is_hot'];
                $goods->sort = $info['sort'];
                $goods->share_title = $info['share_title'];
                $goods->share_content = $info['share_content'];
                $goods->goods_desc = $info['goods_desc'];
                $goods->goods_img = $info['goods_img'];
                $goods->save();

                return Common::jsonFormat('200','添加成功');
            } catch (Exception $e){
                return Common::jsonFormat('500','添加失败');
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商品详情
     */
    public function goodsDetail(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'goods_id' => 'required|numeric',
        ])->validate();

        $data = Goods::find($info['goods_id']);
        if ($data){
            return Common::jsonFormat('200','获取成功',$data);
        }else{
            return Common::jsonFormat('500','获取失败');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 商品删除
     */
    public function goodsDelete(Request $request)
    {
        $info = $request->all();
        Validator::make($info, [
            'goods_id'   => 'required|numeric',
        ])->validate();

        $goods = Goods::find($info['goods_id']);
        if (!$goods){
            return Common::jsonFormat('500','不存在此商品');
        }

        $res = Goods::where('goods_id',$info['goods_id'])->delete();
        if ($res){
            return Common::jsonFormat('200','删除成功');
        }else{
            return Common::jsonFormat('500','删除失败');
        }
    }
}
