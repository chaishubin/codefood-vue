import fetch from '@/utils/fetch'

//获取列表信息
export function getlist(offset,length,order_id,goods_name,order_money,order_time,user_name,tel,sex,pay_way,order_status) {
  return fetch({
    url: '/overseas/orderList',
    method: 'post',
    data: {
      offset,
      length,
      order_id,
      goods_name,
      order_money,
      order_time,
      user_name,
      tel,
      sex,
      pay_way,
      order_status
    }
  })
}
//获取支付方式列表
export function paywaylist() {
  return fetch({
    url: '/overseas/payWay',
    method: 'post',
  })
}
//获取订单状态列表
export function orderstatuslist() {
  return fetch({
    url: '/overseas/orderStatus',
    method: 'post',
  })
}
//导出excel
export function excelexport(offset,length,order_id,goods_name,order_money,order_time,user_name,tel,sex,pay_way,order_status) {
  return fetch({
    url: '/overseas/excelExport',
    method: 'post',
    data: {
      offset,
      length,
      order_id,
      goods_name,
      order_money,
      order_time,
      user_name,
      tel,
      sex,
      pay_way,
      order_status
    }
  })
}