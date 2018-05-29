<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\GoodsCategory;
use App\Models\Seller;
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
        Validator::make($info, [
            'category_name'        => 'nullable',
            'parent_id'            => 'nullable|numeric',
            'parent_category_name' => 'nullable',
            'seller_id'            => 'nullable',
            'seller_name'          => 'nullable',
            'shop_name'            => 'nullable',
            'status'               => 'nullable|boolean',
            'page_num'             => 'nullable|integer',
            'length'               => 'nullable|integer',
        ])->validate();

        $category_query = GoodsCategory::query();

        if (isset($info['category_name']) && !is_null($info['category_name'])){
            $category_query->where('category_name','like','%'.$info['category_name'].'%');
        }
        if (isset($info['parent_id']) && !is_null($info['parent_id'])){
            $category_query->where('parent_id',$info['parent_id']);
        }
        if (isset($info['parent_category_name']) && !is_null($info['parent_category_name'])){
            $parent_category = GoodsCategory::where('category_name','like','%'.$info['parent_category_name'].'%')->get();
            $category_id = [];
            if ($parent_category){
                foreach ($parent_category as $v){
                    $category_id[] = $v['category_id'];
                }
            }
            $category_query->whereIn('parent_id',$category_id);
        }
        if (isset($info['seller_id']) && !is_null($info['seller_id'])){
            $category_query->where('seller_id',$info['seller_id']);
        }
        if (isset($info['seller_name']) && !is_null($info['seller_name'])){
            $seller = Seller::where('username','like','%'.$info['seller_name'].'%')->get();
            $seller_id = [];
            if ($seller){
                foreach ($seller as $v){
                    $seller_id[] = $v['id'];
                }
            }
            $category_query->whereIn('seller_id',$seller_id);
        }
        if (isset($info['shop_name']) && !is_null($info['shop_name'])){
            $seller = Seller::where('shop_name','like','%'.$info['shop_name'].'%')->get();
            $seller_id = [];
            if ($seller){
                foreach ($seller as $v){
                    $seller_id[] = $v['id'];
                }
            }
            $category_query->whereIn('seller_id',$seller_id);
        }
        if (isset($info['status']) && !is_null($info['status'])){
            $category_query->where('status',$info['status']);
        }

        $limit = (isset($info['length']) && !is_null($info['length'])) ? $info['length'] : 10;
        $offset = (isset($info['page_num']) && !is_null($info['page_num'])) ? ($info['page_num']-1)*$limit : 0;

        $category = $category_query->offset($offset)->limit($limit)->orderBy('sort','asc')->get();

        if ($category){
            //拼接好父分类和子分类：父分类/子分类
            foreach ($category as $v){
                $seller = Seller::find($v['seller_id']);
                $v['seller_name'] = $seller['username'];
                $v['shop_name'] = $seller['shop_name'];
            }
        }

        $total = $category_query->count();
        $data = ['total' => $total,'data' => $category];
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
            'goods_name'    => 'nullable',
            'first_category_id'=> 'nullable|numeric',
            'second_category_id'=> 'nullable|numeric',
            'seller_name'   => 'nullable',
            'shop_name'     => 'nullable',
            'goods_tag'     => 'nullable|numeric',
            'is_hot'        => 'nullable|boolean',
            'status'        => 'nullable|integer',
            'page_num'      => 'nullable|integer',
            'length'        => 'nullable|integer',
        ])->validate();

        $limit = (isset($info['length']) && !is_null($info['length'])) ? $info['length'] : 10;
        $offset = (isset($info['page_num']) && !is_null($info['page_num'])) ? ($info['page_num']-1)*$limit : 0;

        $goods_query = Goods::query();

        if (isset($info['goods_name']) && !is_null($info['goods_name'])){
            $goods_query->where('goods_name','like','%'.$info['goods_name'].'%');
        }

        //查询出一级分类下的商品以及其子分类下的商品
        if (isset($info['first_category_id']) && !is_null($info['first_category_id'])){
            $child_category_id[] = $info['first_category_id'];
            //判断二级分类是否为空
            if (isset($info['second_category_id']) && !is_null($info['second_category_id'])){
                $category_id = $info['second_category_id'];
            }else{//为空则只查一级分类下的和其子类下的
                $category_id = $info['first_category_id'];
                $child_category = GoodsCategory::where('parent_id',$info['first_category_id'])->get();
                //判断此一级分类下面是否有子分类，有的话取出其子分类的分类id
                if ($child_category){
                    foreach ($child_category as $v){
                        $child_category_id[] = $v['category_id'];
                    }
                }
            }
            //如果有子类，则用whereIn一并查出一级分类及其子类
            $goods_query->whereIn('category_id',$child_category_id);
        }
        if (isset($info['seller_name']) && !is_null($info['seller_name'])){
            //先模糊查询出符合条件的商家id
            $seller = Seller::where('username','like','%'.$info['seller_name'].'%')->get();
            if ($seller){
                $seller_id = [];
                foreach ($seller as $v){
                    $seller_id[] = $v['id'];
                }
                $goods_query->whereIn('seller_id',$seller_id);
            }
        }
        if (isset($info['shop_name']) && !is_null($info['shop_name'])){
            //先模糊查询出符合条件的商家id
            $seller = Seller::where('shop_name','like','%'.$info['shop_name'].'%')->get();
            if ($seller){
                $seller_id = [];
                foreach ($seller as $v){
                    $seller_id[] = $v['id'];
                }
                $goods_query->whereIn('seller_id',$seller_id);
            }
        }
        if (isset($info['goods_tag']) && !is_null($info['goods_tag'])){
            $goods_query->where('goods_tag',$info['goods_tag']);
        }
        if (isset($info['is_hot']) && !is_null($info['is_hot'])){
            $goods_query->where('is_hot',$info['is_hot']);
        }
        if (isset($info['status']) && !is_null($info['status'])){
            $goods_query->where('status',$info['status']);
        }


        $goods = $goods_query->offset($offset)->limit($limit)->orderBy('sort','asc')->get();

        if ($goods){
            foreach ($goods as $v){
                $v['goods_tag'] = Common::goodsTag($v['goods_tag']);
                $v['is_hot'] = $v['is_hot'] ? '热门' : '非热门';
                $seller = Seller::find($v['seller_id']);
                $v['seller_name'] = $seller ? $seller['username'] : $v['seller_id'];
                $v['shop_name'] = $seller ? $seller['shop_name'] : '';

                $category = GoodsCategory::find($v['category_id']);
                if ($category){
                    if ($category['parent_id'] != 0){
                        $parent = GoodsCategory::find($category['parent_id']);
                        $parent_name = '';
                        if ($parent){
                            $parent_name = $parent['category_name'];
                        }
                        $v['category_name'] = $parent_name.'/'.$category['category_name'];
                    }else{
                        $v['category_name'] = $category['category_name'];
                    }
                }

            }
        }

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
                'first_category_id'=> 'required|numeric',
                'second_category_id'=> 'nullable|numeric',
                'goods_name'    => 'required',
                'seller_id'     => 'required|numeric',
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

            $seller = Seller::find($info['seller_id']);
            if (!$seller){
                return Common::jsonFormat('500','此商家不存在');
            }
            try{
                $goods = new Goods;
                $goods->goods_id = Common::createBigIntId();
                $goods->category_id = (isset($info['second_category_id']) && !is_null($info['second_category_id'])) ? $info['second_category_id'] : $info['first_category_id'];
                $goods->goods_name = $info['goods_name'];
                $goods->seller_id = $info['seller_id'];
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
            $data['first_category'] = '';
            $data['second_category'] = '';

            $category = GoodsCategory::find($data['category_id']);
            if ($category){
                if ($category['parent_id'] == 0){
                    $data['first_category_id'] = $category['category_id'];
                    $data['second_category_id'] = '';
                }else{
                    $data['first_category_id'] = $category['parent_id'];
                    $data['second_category_id'] = $category['category_id'];
                }
            }
            return Common::jsonFormat('200','获取成功',$data);
        }else{
            return Common::jsonFormat('500','商品不存在');
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
