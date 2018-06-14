import fetch from '@/utils/fetch'
//获取列表信息
export function getlist(page_num,length,order_id,user_name,goods_name,order_time,order_status) {
    return fetch({
        url: '/home/orderList',
        method: 'post',
        data: {
            page_num,
            length,
            order_id,
            user_name,
            goods_name,
            order_time,
            order_status
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
//获取产品分类一二级菜单
export function getcategorylist(parent_id) {
    return fetch({
        url: '/overseas/getGoodsCategory',
        method: 'post',
        data: {
            parent_id
        }
    })
}
//添加产品
export function addproduct(first_category_id,second_category_id,goods_name,goods_summary,hospital_name,hospital_summary,hospital_city,sell_price,front_money,specialty,status,share_title,share_content,sort,is_hot,hot_sort,goods_tag,list_img,main_img,hot_img,goods_desc) {
    return fetch({
        url: '/overseas/goodsModify',
        method: 'post',
        data: {
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
//删除订单
export function orderdelete(id) {
    return fetch({
        url: '/home/orderDelete',
        method: 'post',
        data: {
            id
        }
    })
}