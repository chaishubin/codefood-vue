import fetch from '@/utils/fetch'
//获取列表信息
export function getlist(offset,length,user_mobile,username,shop_name,status) {
    return fetch({
        url: '/home/sellerList',
        method: 'post',
        data: {
            offset,
            length,
            user_mobile,
            username,
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

//添加产品
export function addseller(user_mobile,username,password,password_confirmation,address,shop_name,shop_logo,status) {
    return fetch({
        url: '/home/sellerRegister',
        method: 'post',
        data: {
            user_mobile,
            username,
            password,
            password_confirmation,
            address,
            shop_name,
            shop_logo,
            status
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