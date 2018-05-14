import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            redirect: '/login'
        },
        {
            path: '/home',
            component: resolve => require(['../views/layout/Layout.vue'], resolve),
            children:[
                {
                    path: '/',
                    component: resolve => require(['../views/404.vue'], resolve)
                },
                {
                    path: '/HealthcareInternational',
                    component: resolve => require(['../views/healthcareInternational/index.vue'], resolve)
                },
                {
                    path: '/HICustomer',
                    component: resolve => require(['../views/HICustomer/index.vue'], resolve)
                },
                {
                    path: '/adSet',
                    component: resolve => require(['../views/adSet/index.vue'], resolve)
                },
                {
                    path: '/productCategories',
                    component: resolve => require(['../views/productCategories/index.vue'], resolve)
                },
                {
                    path: '/sellers',
                    component: resolve => require(['../views/sellers/index.vue'], resolve)
                },
                {
                    path: '/users',
                    component: resolve => require(['../views/users/index.vue'], resolve)
                },
                {
                    path: '/goods',
                    component: resolve => require(['../views/goods/index.vue'], resolve)
                },
                {
                    path: '/goodsCategory',
                        component: resolve => require(['../views/goodsCategory/index.vue'], resolve)
                },
                {
                    path: '/orders',
                        component: resolve => require(['../views/orders/index.vue'], resolve)
                },
            ],
        },
        {
            path: '/login',
            component: resolve => require(['../views/login/index.vue'], resolve)
        },
    ]
})
