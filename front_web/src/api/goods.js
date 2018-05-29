import fetch from '@/utils/fetch'
//获取列表信息
export function getlist(page_num,length,goods_name,first_category_id,second_category_id,seller_name,shop_name,goods_tag,status) {
    return fetch({
        url: '/manage/goodsList',
        method: 'post',
        data: {
            page_num,
            length,
            goods_name,
            first_category_id,
            second_category_id,
            seller_name,
            shop_name,
            goods_tag,
            status
        }
    })
}
//获取产品标签
export function getGoodsTag(){
    return fetch({
        url: '/manage/goodsTag',
        method: 'post',
        data: {

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
        url: '/manage/goodsCategoryList',
        method: 'post',
        data: {
            parent_id
        }
    })
}
//添加产品
export function addgoods(first_category_id,second_category_id,seller_id,goods_name,goods_summary,sell_price,sort,status,is_hot,goods_tag,share_title,share_content,goods_img,goods_desc) {
    return fetch({
        url: '/manage/goodsModify',
        method: 'post',
        data: {
            first_category_id,
            second_category_id,
            seller_id,
            goods_name,
            goods_summary,
            sell_price,
            sort,
            status,
            is_hot,
            goods_tag,
            share_title,
            share_content,
            goods_img,
            goods_desc
        }
    })
}
//编辑产品
export function editgoods(goods_id,first_category_id,second_category_id,goods_name,goods_summary,hospital_name,hospital_summary,hospital_city,sell_price,front_money,specialty,status,share_title,share_content,sort,is_hot,hot_sort,goods_tag,list_img,main_img,hot_img,goods_desc) {
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
        url: '/manage/goodsDetail',
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
// //添加产品分类
// export function addgoods(first_category_id,second_category_id,seller_id,goods_name,goods_summary,sell_price,sort,status,is_hot,goods_tag,share_title,share_content,goods_img,goods_desc) {
//     return fetch({
//         url: '/manage/goodsModify',
//         method: 'post',
//         data: {
//             first_category_id,
//             second_category_id,
//             seller_id,
//             goods_name,
//             goods_summary,
//             sell_price,
//             sort,
//             status,
//             is_hot,
//             goods_tag,
//             share_title,
//             share_content,
//             goods_img,
//             goods_desc
//         }
//     })
// }