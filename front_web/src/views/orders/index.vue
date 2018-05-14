<template>
    <div id="orders">
        <div class="handle-box">
            <el-row type="flex" justify="end" style="margin-bottom:20px;">
                <el-col :span="2">
                    <el-row type="flex" justify="end">
                        <el-button type="primary" @click="addpt()">添加</el-button>
                    </el-row>
                </el-col>
            </el-row>
            <el-form :inline="true" class="demo-form-inline" size="small">
                <el-row type="flex">
                    <el-col :span="6">
                        <el-form-item label="订单id：">
                            <el-input v-model.trim="order_id" placeholder="订单id："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="用户姓名：">
                            <el-input v-model.trim="user_name" placeholder="用户姓名："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="商品名称：">
                            <el-input v-model.trim="goods_name" placeholder="商品名称："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="下单时间：">
                            <el-input v-model.trim="order_time" placeholder="下单时间："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="订单状态：">
                            <el-select v-model="order_status" clearable placeholder="请选择">
                                <el-option label="待付款" value="101"></el-option>
                                <el-option label="已付款" value="102"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row type="flex">
                    <el-col>
                        <el-row type="flex" justify="end">
                            <el-button type="primary" @click="search">搜索</el-button>
                        </el-row>
                    </el-col>
                </el-row>
            </el-form>
        </div>
        <div class="tablelist" style="width:100%;">
            <el-table :data="tableData" border style="width: 100%">
                <el-table-column prop="id" label="订单id">
                </el-table-column>
                <el-table-column prop="user_name" label="用户姓名">
                </el-table-column>
                <el-table-column prop="goods_name" label="商品名称">
                </el-table-column>
                <el-table-column prop="order_money" label="订单金额">
                </el-table-column>
                <el-table-column prop="coupon" label="优惠券">
                </el-table-column>
                <el-table-column prop="pay_way" label="支付方式">
                </el-table-column>
                <el-table-column prop="order_time" label="下单时间">
                </el-table-column>
                <el-table-column prop="pay_time" label="付款时间">
                </el-table-column>
                <el-table-column prop="order_status" label="订单状态">
                </el-table-column>
                <el-table-column label="操作" width="250">
                    <template slot-scope="scope">
                        <el-button size="small" @click="editpt(scope.row.id)">编辑</el-button>
                        <el-button size="small" type="danger" @click="deleteorder(scope.row.id)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="pagination" style="margin:20px 0;">
                <el-row type="flex" align="middle" justify="end">
                    <!--<span class="demonstration" style="font-size: 14px;color: #8492a6;">显示总数</span>-->
                    <el-pagination @current-change="handleCurrentChange" background layout="total,prev, pager, next" :total="total" :page-size="pagesize">
                    </el-pagination>
                </el-row>
            </div>
        </div>
        <addproduct v-if="addshow" :show.sync="addshow" @closedialog="addChange"></addproduct>
        <editproduct v-if="editshow" :show.sync="editshow" :id.sync="id" @closedialog="editChange"></editproduct>
    </div>
</template>

<script>
//    import addproduct from './components/addProduct';
//    import editproduct from './components/editProduct';
    import { getlist } from "@/api/order.js";
    export default {
        data() {
            return {
                tableData: [

                ],
                firstOptions: [

                ],
                secondOptions: [

                ],
                order_id:'',
                user_name:'',
                goods_name:'',
                order_time:'',
                order_status:'',
                total:0,
                pagesize:10,
                cur_page: 1,
                addshow:false,
                editshow:false,
                id:'',
            }
        },
        created(){
            this.getData();
//            this.firstCategory();
        },
        components: {
//            addproduct,
//            editproduct,
        },
        mounted() {

        },
        methods: {
            addpt(){
                this.addshow = true;
            },
            editpt(id){
                this.id = id;
                this.editshow = true;
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                getlist(this.cur_page,this.pagesize,this.order_id,this.user_name,this.goods_name,this.order_time,this.order_status).then(res => {
                    console.log(res.data.data)
                    this.total = res.data.data.total;
                    this.tableData = res.data.data[0];
                }).catch(err => {
                    console.log(err)
                })
            },
            search(){
                this.getData();
            },
            addChange(){
                this.addshow = false;
                this.getData();
            },
            editChange(){
                this.editshow = false;
                this.getData();
            },
            changeStatus(id,status){
                modify(id,status).then(res => {
                    console.log(res.data)
                    if(res.data.status == '200'){
                        this.getData();
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: 'success'
                        });
                    }else{
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: 'error'
                        });
                    }
                }).catch(err => {
                    console.log(error)
                })
            },
            deleteorder(id) {
                const _this = this;
                sellerdelete(id).then(res => {
                    console.log(res)
                    if(res.data.status == '200'){
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: 'success'
                        });
                        _this.getData();
                    }else{
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: 'error'
                        });
                    }
                }).catch(err => {
                    console.log(err)
                })
            }
        }
    }
</script>
