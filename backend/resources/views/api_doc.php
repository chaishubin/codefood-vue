<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>春风 - DOC 接口文档</title>

<!-- Bootstrap core CSS -->
<link href="css/api/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="css/api/default.css">

<style type="text/css">
html,body{ overflow:hidden;height: 100%; }
.content{background-color: rgba(255, 255, 255, 0.92);height: 100%;}
h2{ margin:0; padding:25px 0; }
#sidebar{ overflow-y:auto; padding-right:20px; padding-left:20px; padding-top:20px; box-shadow:2px 2px 3px rgba(223, 223, 223, 0.59); }
#result .input-group{  margin-right:50px; box-shadow:2px 2px 3px rgba(223, 223, 223, 0.59); margin-bottom:10px; }
.item-result{ margin-bottom:15px; margin-right:50px; }
.item-result pre{ overflow-y:scroll; background-color: rgba(221, 221, 221, 0.22); box-shadow:2px 2px 3px rgba(223, 223, 223, 0.59); clear:both;  margin-bottom:20px;}
.item-result h5{float: right;
    position: relative;
    margin-bottom: -28px;
    margin-right: 16px;
    background-color: rgba(197, 197, 197, 0.28);
    padding: 6px 14px;
    color: green;  }
.item-doc{ border:1px solid #ccc; padding:0 10px; margin-bottom:5px; border-radius:3px; box-shadow:2px 2px 3px rgba(223, 223, 223, 0.59); }
.item-doc form{ padding-bottom:10px; display:none; }
.item-doc em{ color:red; }
.item-doc .input-group{ margin-bottom:10px; width:95%; }
.item-doc .input-group-addon{ width:45%; text-align:right;}
.item-doc h5{  cursor:pointer; }
.item-doc h5 .link{ color:#2a6496; }
.alert-warning{ background-color: rgba(245, 236, 189, 0.52); }
</style>
</head>
<body>
<div class="content">

<h2 class="text-center">Web - 接口文档</h2>

<div class="row">
    <div class="col-md-3">
        <ul class="nav sidebar-nav" id="sidebar">
            <li>
                <div class="item-doc">
                    <h5>说明：</h5>
                    <p>
                        [code]  <br />
                        =200  &nbsp;&nbsp;   ok<br />
                        =404   &nbsp;&nbsp;     数据不存在<br />
                        =500   &nbsp;&nbsp;     错误
                    </p>

                </div>
            </li>
            <li>
                <h3>订单</h3>
                <div class="item-doc">
                    <h5>订单列表: <small class="link">/api/home/orderList</small></h5>
                    <form role="form" action="/api/home/orderList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">id</span><input name="id" placeholder="订单id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">user_id</span><input name="user_id" placeholder="用户id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">user_name</span><input name="user_name" placeholder="用户姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_name</span><input name="goods_name" placeholder="产品名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">order_time</span><input name="order_time" placeholder="下单时间" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">order_status</span><input name="order_status" placeholder="订单状态" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">page_num</span><input name="page_num" placeholder="当前页数" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">length</span><input name="length" placeholder="条数" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>提交订单: <small class="link">/api/home/orderAdd</small></h5>
                    <form role="form" action="/api/home/orderAdd">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">user_id</span><input name="user_id" placeholder="用户ID" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">order_money</span><input name="order_money" placeholder="订单金额" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">coupon</span><input name="coupon" placeholder="优惠券" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">pay_way</span><input name="pay_way" placeholder="支付方式" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>修改订单: <small class="link">/api/home/orderModify</small></h5>
                    <form role="form" action="/api/home/orderModify">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">order_id</span><input name="order_id" placeholder="订单ID" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">pay_money</span><input name="pay_money" placeholder="订单金额" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </li>
            <li>
                <h3>海外医疗</h3>
                <div class="item-doc">
                    <h5>商品分类列表: <small class="link">/api/manage/goodsCategoryList</small></h5>
                    <form role="form" action="/api/manage/goodsCategoryList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">category_name</span><input name="category_name" placeholder="分类名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">parent_category_name</span><input name="parent_category_name" placeholder="上级分类名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">seller_name</span><input name="seller_name" placeholder="商家姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">shop_name</span><input name="shop_name" placeholder="店铺名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="状态" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">page_num</span><input name="page_num" placeholder="当前页数" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">length</span><input name="length" placeholder="条数" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>获取所有商品分类: <small class="link">/api/manage/getGoodsCategoryList</small></h5>
                    <form role="form" action="/api/manage/getGoodsCategoryList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>添加\修改商品分类: <small class="link">/api/manage/goodsCategoryModify</small></h5>
                    <form role="form" action="/api/manage/goodsCategoryModify">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">category_id</span><input name="category_id" placeholder="分类id(仅在修改时填写)" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">parent_id</span><input name="parent_id" placeholder="上级分类id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">seller_id</span><input name="seller_id" placeholder="商家id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">category_name</span><input name="category_name" placeholder="分类名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">category_img</span><input name="category_img" placeholder="分类图片" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="状态" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">sort</span><input name="sort" placeholder="排序" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商品分类详情: <small class="link">/api/manage/goodsCategoryDetail</small></h5>
                    <form role="form" action="/api/manage/goodsCategoryDetail">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">category_id</span><input name="category_id" placeholder="分类id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商品分类删除: <small class="link">/api/manage/goodsCategoryDelete</small></h5>
                    <form role="form" action="/api/manage/goodsCategoryDelete">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">category_id</span><input name="category_id" placeholder="分类id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商品列表: <small class="link">/api/manage/goodsList</small></h5>
                    <form role="form" action="/api/manage/goodsList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">goods_name</span><input name="goods_name" placeholder="产品名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">first_category_id</span><input name="first_category_id" placeholder="一级分类id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">second_category_id</span><input name="second_category_id" placeholder="二级分类id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">seller_name</span><input name="seller_name" placeholder="商家姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">shop_name</span><input name="shop_name" placeholder="店铺名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_tag</span><input name="goods_tag" placeholder="产品标签" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="产品状态" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">page_num</span><input name="page_num" placeholder="当前页数" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">length</span><input name="length" placeholder="条数" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>添加\修改商品: <small class="link">/api/manage/goodsModify</small></h5>
                    <form role="form" action="/api/manage/goodsModify">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id(仅在修改时填写)" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">category_id</span><input name="category_id" placeholder="分类id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_name</span><input name="goods_name" placeholder="产品名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">seller_id</span><input name="seller_id" placeholder="商家id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_summary</span><input name="goods_summary" placeholder="产品简要" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">sell_price</span><input name="sell_price" placeholder="售价" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_tag</span><input name="goods_tag" placeholder="产品标签" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="产品状态，0下架，1上架" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">is_hot</span><input name="is_hot" placeholder="是否热门，0非热门，1热门" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">sort</span><input name="sort" placeholder="排序" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">share_title</span><input name="share_title" placeholder="分享标题" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">share_content</span><input name="share_content" placeholder="分享描述" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_desc</span><input name="goods_desc" placeholder="产品描述" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_img</span><input name="goods_img" placeholder="商品图片" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商品详情: <small class="link">/api/manage/goodsDetail</small></h5>
                    <form role="form" action="/api/manage/goodsDetail">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商品删除: <small class="link">/api/manage/goodsDelete</small></h5>
                    <form role="form" action="/api/manage/goodsDelete">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>支付方式接口: <small class="link">/api/overseas/payWay</small></h5>
                    <form role="form" action="/api/overseas/payWay">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>订单状态接口: <small class="link">/api/overseas/orderStatus</small></h5>
                    <form role="form" action="/api/overseas/orderStatus">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>提交订单: <small class="link">/api/overseas/orderAdd</small></h5>
                    <form role="form" action="/api/overseas/orderAdd">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">user_id</span><input name="user_id" placeholder="用户ID" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">order_money</span><input name="order_money" placeholder="订单金额" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">front_money</span><input name="front_money" placeholder="定金" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">coupon</span><input name="coupon" placeholder="优惠券" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">pay_money</span><input name="pay_money" placeholder="实付金额" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">pay_way</span><input name="pay_way" placeholder="支付方式" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">patient_name</span><input name="patient_name" placeholder="病人姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">relationship</span><input name="relationship" placeholder="关系" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">sex</span><input name="sex" placeholder="性别:1男，2女，3其他" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">birthdate</span><input name="birthdate" placeholder="出生日期" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">tel</span><input name="tel" placeholder="联系电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">eamil</span><input name="eamil" placeholder="eamil" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>微信支付: <small class="link">/api/overseas/goodsDetail</small></h5>
                    <form role="form" action="/api/overseas/goodsDetail">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>订单列表: <small class="link">/api/overseas/orderList</small></h5>
                    <form role="form" action="/api/overseas/orderList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">user_id</span><input name="user_id" placeholder="用户id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">order_status</span><input name="order_status" placeholder="订单状态" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>订单详情: <small class="link">/api/overseas/orderDetail</small></h5>
                    <form role="form" action="/api/overseas/orderDetail">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">order_id</span><input name="order_id" placeholder="订单id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </li>
            <li>
                <h3>用户</h3>
                <div class="item-doc">
                    <h5>用户注册: <small class="link">/api/home/userRegister</small></h5>
                    <form role="form" action="/api/home/userRegister">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">name</span><input name="name" placeholder="姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">tel</span><input name="tel" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password</span><input name="password" placeholder="密码" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password_confirmation</span><input name="password_confirmation" placeholder="密码确认" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">email</span><input name="email" placeholder="邮箱" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">icon</span><input name="icon" placeholder="头像" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">open_id</span><input name="open_id" placeholder="微信open_id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="状态" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>用户登录: <small class="link">/api/home/userLogin</small></h5>
                    <form role="form" action="/api/home/userLogin">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">tel</span><input name="tel" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password</span><input name="password" placeholder="密码" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>用户列表: <small class="link">/api/manage/userList</small></h5>
                    <form role="form" action="/api/manage/userList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">name</span><input name="name" placeholder="姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">tel</span><input name="tel" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password</span><input name="password" placeholder="密码" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">email</span><input name="email" placeholder="邮箱" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">icon</span><input name="icon" placeholder="头像" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">open_id</span><input name="open_id" placeholder="微信open_id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>用户信息修改: <small class="link">/api/home/userModify</small></h5>
                    <form role="form" action="/api/home/userModify">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">id</span><input name="id" placeholder="用户id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">name</span><input name="name" placeholder="姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">tel</span><input name="tel" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password</span><input name="password" placeholder="密码" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password_confirmation</span><input name="password_confirmation" placeholder="密码确认" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">email</span><input name="email" placeholder="邮箱" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">icon</span><input name="icon" placeholder="头像" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>用户收藏列表: <small class="link">/api/home/userCollectionList</small></h5>
                    <form role="form" action="/api/home/userCollectionList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">user_id</span><input name="user_id" placeholder="用户id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>用户收藏添加\修改: <small class="link">/api/home/userCollectionModify</small></h5>
                    <form role="form" action="/api/home/userCollectionModify">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">collection_id</span><input name="collection_id" placeholder="收藏id(修改时才填写)" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="收藏状态(收藏1，取消收藏0)(修改时才填写)" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">user_id</span><input name="user_id" placeholder="用户id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">goods_id</span><input name="goods_id" placeholder="商品id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </li>
            <li>
                <h3>商家</h3>
                <div class="item-doc">
                    <h5>商家列表: <small class="link">/api/home/sellerList</small></h5>
                    <form role="form" action="/api/home/sellerList">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">user_mobile</span><input name="user_mobile" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">username</span><input name="username" placeholder="商户姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">shop_name</span><input name="shop_name" placeholder="店铺名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="条数" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">page_num</span><input name="page_num" placeholder="当前页数" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">length</span><input name="length" placeholder="条数" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商家注册: <small class="link">/api/home/sellerRegister</small></h5>
                    <form role="form" action="/api/home/sellerRegister">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">user_mobile</span><input name="user_mobile" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">username</span><input name="username" placeholder="商户姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password</span><input name="password" placeholder="密码" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password_confirmation</span><input name="password_confirmation" placeholder="密码确认" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">address</span><input name="address" placeholder="店铺地址" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">shop_name</span><input name="shop_name" placeholder="店铺名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">shop_logo</span><input name="shop_logo" placeholder="店铺头像" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="商家状态" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商家登录: <small class="link">/api/home/sellerLogin</small></h5>
                    <form role="form" action="/api/home/sellerLogin">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">user_mobile</span><input name="user_mobile" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password</span><input name="password" placeholder="密码" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="item-doc">
                    <h5>商家信息修改: <small class="link">/api/home/sellerModify</small></h5>
                    <form role="form" action="/api/home/sellerModify">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">id</span><input name="id" placeholder="商家id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">user_mobile</span><input name="user_mobile" placeholder="电话" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">username</span><input name="username" placeholder="商家姓名" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">password</span><input name="password" placeholder="密码" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">address</span><input name="address" placeholder="店铺地址" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">shop_name</span><input name="shop_name" placeholder="店铺名称" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">shop_logo</span><input name="shop_logo" placeholder="店铺头像" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">status</span><input name="status" placeholder="商家状态,1启用，0禁用" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </li>
            <li>
                <h3>微信相关</h3>
                <div class="item-doc">
                    <h5>微信支付: <small class="link">/api/wechat/wxPay</small></h5>
                    <form role="form" action="/api/wechat/wxPay">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon">open_id</span><input name="open_id" placeholder="微信open_id" value="" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">order_id</span><input name="order_id" placeholder="订单id" value="" type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>



            </li>

         </ul>
     </div>

    <div class="col-md-9" id="result">
        <div class="input-group">
            <span class="input-group-addon">请求URL</span><input id="url" value="" type="text" class="form-control" onclick="this.select()" />
        </div>
        <div class="item-result">
            <h5>json</h5>
            <pre></pre>
        </div>
        <div class="item-result">
            <h5>文本</h5>
            <pre></pre>
        </div>
    </div>
</div>


</div>
<script src="js/api/jquery-1.9.1.min.js"></script>
<script src="js/api/jquery.form.js"></script>
<script src="js/api/highlight.pack.js"></script>
<!--<script src="static/lib/bootstrap/js/bootstrap.min.js"></script>-->
<script>
    var JsonUti = {
        //定义换行符
        n: "\n",
        //定义制表符
        t: "   ",
        //转换String
        convertToString: function(obj) {
            return JsonUti.__writeObj(obj, 1);
        },
        //写对象
        __writeObj: function(obj //对象
                , level //层次（基数为1）
                , isInArray) { //此对象是否在一个集合内
            //如果为空，直接输出null
            if (obj == null) {
                return "null";
            }
            //为普通类型，直接输出值
            if (obj.constructor == Number || obj.constructor == Date || obj.constructor == String || obj.constructor == Boolean) {
                var v = obj.toString();
                var tab = isInArray ? JsonUti.__repeatStr(JsonUti.t, level - 1) : "";
                if (obj.constructor == String || obj.constructor == Date) {
                    //时间格式化只是单纯输出字符串，而不是Date对象
                    return tab + ("\"" + v + "\"");
                }
                else if (obj.constructor == Boolean) {
                    return tab + v.toLowerCase();
                }
                else {
                    return tab + (v);
                }
            }
            //写Json对象，缓存字符串
            var currentObjStrings = [];
            //遍历属性
            for (var name in obj) {
                var temp = [];
                //格式化Tab
                var paddingTab = JsonUti.__repeatStr(JsonUti.t, level);
                temp.push(paddingTab);
                //写出属性名
                temp.push("\"" + name + "\" : ");
                var val = obj[name];
                if (val == null) {
                    temp.push("null");
                }
                else {
                    var c = val.constructor;
                    if (c == Array) { //如果为集合，循环内部对象
                        temp.push(JsonUti.n + paddingTab + "[" + JsonUti.n);
                        var levelUp = level + 2; //层级+2
                        var tempArrValue = []; //集合元素相关字符串缓存片段
                        for (var i = 0; i < val.length; i++) {
                            //递归写对象
                            tempArrValue.push(JsonUti.__writeObj(val[i], levelUp, true));
                        }
                        temp.push(tempArrValue.join("," + JsonUti.n));
                        temp.push(JsonUti.n + paddingTab + "]");
                    }
                    else if (c == Function) {
                        temp.push("[Function]");
                    }
                    else {
                        //递归写对象
                        temp.push(JsonUti.__writeObj(val, level + 1));
                    }
                }
                //加入当前对象“属性”字符串
                currentObjStrings.push(temp.join(""));
            }
            return (level > 1 && !isInArray ? JsonUti.n: "") //如果Json对象是内部，就要换行格式化
                    + JsonUti.__repeatStr(JsonUti.t, level - 1) + "{" + JsonUti.n //加层次Tab格式化
                    + currentObjStrings.join("," + JsonUti.n) //串联所有属性值
                    + JsonUti.n + JsonUti.__repeatStr(JsonUti.t, level - 1) + "}"; //封闭对象
        },
        __isArray: function(obj) {
            if (obj) {
                return obj.constructor == Array;
            }
            return false;
        },
        __repeatStr: function(str, times) {
            var newStr = [];
            if (times > 0) {
                for (var i = 0; i < times; i++) {
                    newStr.push(str);
                }
            }
            return newStr.join("");
        }
    };
</script>
<script>
$(function(){
    var $result=$('#result')
            , $sidebar=$('#sidebar')
            , $children=$result.children()
            , $pre=$children.find('pre')
            , offsetTop=$result.offset().top;
    $(window).resize(function(){
        var height=(document.documentElement.clientHeight-offsetTop-140)/2;
        $pre.eq(0).height( height*0.7*2 );
        $pre.eq(1).height( height*0.3*2 );
        $sidebar.height( document.documentElement.clientHeight-offsetTop-35 );
    }).trigger('resize');

    function getUrl( $form ){
        return $form.attr('action')
    }
    $('form').submit(function(e){
        e.stopPropagation();
        var $this=$(this);
        var url=getUrl($this);
        $pre.html('');
        $('#url').val( window.location.origin + url );
        $this.ajaxSubmit({
            type:'post',
            url:url,
			dataType: 'text',
            success:function( jsonText ){
                var text=jsonText;
                try{
                    var json=$.parseJSON( jsonText );
                    jsonText=JsonUti.convertToString(json);
                }catch(e){}
                $pre.eq(0).html( jsonText );
                $pre.eq(1).html( text );
                hljs.highlightBlock( $pre[0] );
                hljs.highlightBlock( $pre[1] );
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $pre.html( '' );
                $pre.eq(0).html( 'status:'+XMLHttpRequest.status+'<br><br>'+XMLHttpRequest.responseText );
            }
        });
        return false;
    });

    $('#sidebar h5').click(function(){
        $(this).next('form').toggle();
    })
});
</script>
</body>
</html>

