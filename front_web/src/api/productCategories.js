import fetch from '@/utils/fetch'
//获取列表信息
export function getlist(name,parent_id,status) {
  return fetch({
    url: '/overseas/goodsCategoryList',
    method: 'post',
    data: {
      name,
      parent_id,
      status
    }
  })
}
//获取上级分类
export function getcategoryparentlist(parent_id) {
  return fetch({
    url: '/overseas/getGoodsCategory',
    method: 'post',
    data: {
      parent_id
    }
  })
}
//添加分类
export function addmodify(parent_id,name,icon,sort,status) {
  return fetch({
    url: '/overseas/goodsCategoryModify',
    method: 'post',
    data: {
      parent_id,
      name,
      icon,
      sort,
      status
    }
  })
}
//编辑分类
export function editmodify(category_id,parent_id,name,icon,sort,status) {
  return fetch({
    url: '/overseas/goodsCategoryModify',
    method: 'post',
    data: {
      category_id,
      parent_id,
      name,
      icon,
      sort,
      status
    }
  })
}
//获取分类详情
export function getcategorydetail(category_id) {
  return fetch({
    url: '/overseas/goodsCategoryDetail',
    method: 'post',
    data: {
      category_id
    }
  })
}
//删除分类
export function goodscategorydelete(category_id) {
  return fetch({
    url: '/overseas/goodsCategoryDelete',
    method: 'post',
    data: {
      category_id
    }
  })
}