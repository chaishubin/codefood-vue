<template>
  <div class="menu-wrapper">
      <template v-for="item in routedata">
        <template v-if="item.subs">
          <el-submenu :index="item.index">
              <template slot="title"><i :class="item.icon"></i>{{ item.title }}</template>
              <template v-for="(subItem,i) in item.subs">
                <template v-if="subItem.subs">
                  <el-submenu :index="subItem.index">
                    <template slot="title" style="backgroundColor:#1f2d3d !important;"><i :class="subItem.icon"></i>{{ subItem.title }}</template>
                    <el-menu-item v-for="(childItem,i) in subItem.subs" :key="i" :index="childItem.index">{{ childItem.title }}
                    </el-menu-item>
                  </el-submenu>
                </template>
                <template v-else>
                  <el-menu-item :index="subItem.index">{{ subItem.title }}
                  </el-menu-item>
                </template>
              </template>
          </el-submenu>
        </template>
        <template v-else>
            <el-menu-item :index="item.index">
                <i :class="item.icon"></i>{{ item.title }}
            </el-menu-item>
        </template>
      </template>
  </div>
</template>

<script>
export default {
  name: 'SidebarItem',
  data:function(){
    return {
      routedata:[
        {
            icon: 'el-icon-menu',
            index: '1',
            title: '运营中心',
            subs: [
                {
                    index: '1-1',
                    title: '产品管理',
                    subs:[
                      {
                        index: 'HealthcareInternational',
                        title: '国际医疗'
                      },
                      {
                        index: 'HICustomer',
                        title: '国际医疗客户信息'
                      },
                    ]
                },
            ]
        },
        {
            icon: 'el-icon-setting',
            index: '2',
            title: '设置中心',
            subs: [
                {
                    index: 'adSet',
                    title: '广告设置',
                },
                {
                    index: '2-1',
                    title: '基础设置',
                    subs: [
                      {
                        index: 'productCategories',
                        title: '产品分类'
                      },
                    ]
                },
            ]
        },
        {
          icon: 'el-icon-setting',
          index: '3',
          title: '商家中心',
          subs: [
              {
                  index: 'sellers',
                  title: '商家列表',
              },
          ]
        },
        {
          icon: 'el-icon-setting',
          index: '4',
          title: '用户中心',
          subs: [
              {
                  index: 'users',
                  title: '用户列表',
              },
          ]
        },
        {
          icon: 'el-icon-setting',
          index: '5',
          title: '订单中心',
          subs: [
              {
                  index: 'orders',
                  title: '订单列表',
              },
          ]
        },
        {
          icon: 'el-icon-setting',
          index: '6',
          title: '商品中心',
          subs: [
              {
                  index: 'goods',
                  title: '商品列表',
              },
              {
                  index: 'goodsCategory',
                  title: '商品分类列表',
              },
          ]
        },

        ]
    }
  },
}
</script>
