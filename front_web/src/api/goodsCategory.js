import fetch from '@/utils/fetch'
//获取列表信息
export function getlist(page_num,length,category_name,parent_category_name,seller_name,shop_name,status) {
    return fetch({
        url: '/manage/goodsCategoryList',
        method: 'post',
        data: {
            page_num,
            length,
            category_name,
            parent_category_name,
            seller_name,
            shop_name,
            status
        }
    })
}
//修改产品状态
export function modify(goods_id,status) {
    return fetch({
        url: '/overseas/goodsStatus',
        method: 'post',
        data: {
            goods_id,
            status
        }
    })
}
//获取一级产品分类
export function getParentCategoryList(parent_id,seller_id) {
    return fetch({
        url: '/manage/goodsCategoryList',
        method: 'post',
        data: {
            parent_id,
            seller_id
        }
    })
}
//添加产品分类
export function addcategory(category_name,parent_id,seller_id,category_img,status,sort) {
    return fetch({
        url: '/manage/goodsCategoryModify',
        method: 'post',
        data: {
            category_name,
            parent_id,
            seller_id,
            category_img,
            status,
            sort
        }
    })
}
//编辑产品
export function editproduct(goods_id,first_category_id,second_category_id,goods_name,goods_summary,hospital_name,hospital_summary,hospital_city,sell_price,front_money,specialty,status,share_title,share_content,sort,is_hot,hot_sort,goods_tag,list_img,main_img,hot_img,goods_desc) {
    return fetch({
        url: '/overseas/goodsModify',
        method: 'post',
        data: {
            goods_id,
            first_category_id,
            second_category_id,
            goods_name,
            goods_summary,
            hospital_name,
            hospital_summary,
            hospital_city,
            sell_price,
            front_money,
            specialty,
            status,
            share_title,
            share_content,
            sort,
            is_hot,
            hot_sort,
            goods_tag,
            list_img,
            main_img,
            hot_img,
            goods_desc
        }
    })
}
//获取产品信息
export function getgoodsinfo(goods_id) {
    return fetch({
        url: '/overseas/goodsDetail',
        method: 'post',
        data: {
            goods_id
        }
    })
}
//删除产品
export function goodsdelete(goods_id) {
    return fetch({
        url: '/overseas/goodsDelete',
        method: 'post',
        data: {
            goods_id
        }
    })
}