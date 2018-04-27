import fetch from '@/utils/fetch'
//获取广告分类菜单
export function categorylist() {
  return fetch({
    url: '/banner/categoryList',
    method: 'post',
  })
}
//获取广告位置菜单
export function bannerposition() {
  return fetch({
    url: '/banner/bannerPosition',
    method: 'post',
  })
}

//获取列表信息
export function getlist(offset,length,name,platform,position,category_id,status) {
  return fetch({
    url: '/banner/bannerList',
    method: 'post',
    data: {
      offset,
      length,
      name,
      platform,
      position,
      category_id,
      status
    }
  })
}

//获取平台列表
export function platformlist() {
  return fetch({
    url: '/banner/platForm',
    method: 'post',
  })
}
//添加广告
export function addbanner(name,platform,position,category_id,sort,status,lifecycle,url,img) {
  return fetch({
    url: '/banner/bannerModify',
    method: 'post',
    data: {
      name,
      platform,
      position,
      category_id,
      sort,
      status,
      lifecycle,
      url,
      img
    }
  })
}
//编辑广告
export function editbanner(banner_id,name,platform,position,category_id,sort,status,lifecycle,url,img) {
  return fetch({
    url: '/banner/bannerModify',
    method: 'post',
    data: {
      banner_id,
      name,
      platform,
      position,
      category_id,
      sort,
      status,
      lifecycle,
      url,
      img
    }
  })
}
//获取广告详情
export function getbannerdetail(banner_id) {
  return fetch({
    url: '/banner/bannerDetail',
    method: 'post',
    data: {
      banner_id
    }
  })
}
//删除banner
export function bannerDelete(banner_id) {
  return fetch({
    url: '/banner/bannerDelete',
    method: 'post',
    data: {
      banner_id
    }
  })
}


