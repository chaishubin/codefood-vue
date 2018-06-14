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
export function modify(category_id,status) {
    return fetch({
        url: '/manage/goodsCategoryModify',
        method: 'post',
        data: {
            category_id,
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
export function editcategory(category_id,category_name,parent_id,seller_id,category_img,status,sort) {
    return fetch({
        url: '/manage/goodsCategoryModify',
        method: 'post',
        data: {
            category_id,
            category_name,
            parent_id,
            seller_id,
            category_img,
            status,
            sort
        }
    })
}
//获取产品分类信息
export function getcategoryinfo(category_id) {
    return fetch({
        url: '/manage/goodsCategoryDetail',
        method: 'post',
        data: {
            category_id
        }
    })
}
//删除产品分类
export function categorydelete(category_id) {
    return fetch({
        url: '/manage/goodsCategoryDelete',
        method: 'post',
        data: {
            category_id
        }
    })
}