import fetch from '@/utils/fetch'
//获取列表信息
export function getlist(page_num,length,user_mobile,username,shop_name,status) {
    return fetch({
        url: '/home/sellerList',
        method: 'post',
        data: {
            page_num,
            length,
            user_mobile,
            username,
            shop_name,
            status
        }
    })
}
//修改商户状态
export function modify(id,status) {
    return fetch({
        url: '/home/sellerModify',
        method: 'post',
        data: {
            id,
            status
        }
    })
}
//添加商家
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
//编辑商户
export function editseller(id,user_mobile,username,password,password_confirmation,address,shop_name,shop_logo,status) {
    return fetch({
        url: '/home/sellerModify',
        method: 'post',
        data: {
            id,
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
//获取商家信息
export function getsellerinfo(id) {
    return fetch({
        url: '/home/sellerDetail',
        method: 'post',
        data: {
            id
        }
    })
}
//删除商家
export function sellerdelete(id) {
    return fetch({
        url: '/home/sellerDelete',
        method: 'post',
        data: {
            id
        }
    })
}