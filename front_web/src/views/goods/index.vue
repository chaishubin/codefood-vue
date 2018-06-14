<template>
    <div id="goods">
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
                        <el-form-item label="产品名称：">
                            <el-input v-model.trim="goods_name" placeholder="产品名称："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="18">
                        <el-form-item label="产品分类：">
                            <el-col :span="11">
                                <el-select v-model="first_category_id" clearable placeholder="请选择" @change="secondCategory(first_category_id)">
                                    <el-option v-for="item in firstOptions" :key="item.category_id" :label="item.category_name" :value="item.category_id"></el-option>
                                </el-select>
                            </el-col>
                            <el-col :span="11" :offset="2">
                                <el-select style="width:100%;" clearable v-model="second_category_id" placeholder="请选择">
                                    <el-option v-for="item in secondOptions" :key="item.category_id" :label="item.category_name" :value="item.category_id"></el-option>
                                </el-select>
                            </el-col>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row type="flex">
                    <el-col :span="6">
                        <el-form-item label="商家姓名：">
                            <el-input v-model.trim="seller_name" placeholder="商家姓名："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="店铺名称：">
                            <el-input v-model.trim="shop_name" placeholder="店铺名称："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="产品标签：">
                            <el-select v-model="goods_tag" clearable placeholder="请选择">
                                <el-option v-for="item in goodsTagOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="产品状态：">
                            <el-select v-model="status" clearable placeholder="请选择">
                                <el-option label="上架" value="1"></el-option>
                                <el-option label="下架" value="0"></el-option>
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
                <el-table-column prop="goods_id" label="商品id">
                </el-table-column>
                <el-table-column prop="goods_name" label="商品名称">
                </el-table-column>
                <el-table-column prop="category_name" label="分类">
                </el-table-column>
                <el-table-column prop="seller_name" label="商家姓名">
                </el-table-column>
                <el-table-column prop="shop_name" label="店铺名称">
                </el-table-column>
                <el-table-column prop="sell_price" label="售价">
                </el-table-column>
                <el-table-column prop="goods_tag" label="产品标签">
                </el-table-column>
                <el-table-column prop="status" :formatter="formatStatus" label="产品状态">
                </el-table-column>
                <el-table-column prop="is_hot" label="是否热门">
                </el-table-column>
                <el-table-column prop="sort" label="排序">
                </el-table-column>
                <el-table-column label="商品图片">
                    <template scope="scope">
                        <img :src="scope.row.goods_img" width="50" height="50"/>
                    </template>
                </el-table-column>
                <el-table-column label="操作" width="250">
                    <template slot-scope="scope">
                        <el-button v-if="scope.row.status === 0" size="small" @click="changeStatus(scope.row.goods_id,1)">上架</el-button>
                        <el-button v-else-if="scope.row.status === 1" size="small" @click="changeStatus(scope.row.goods_id,0)">下架</el-button>
                        <el-button size="small" @click="editpt(scope.row.goods_id)">编辑</el-button>
                        <el-button size="small" type="danger" @click="deletegoods(scope.row.goods_id)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="pagination" style="margin:20px 0;">
                <el-row type="flex" align="middle" justify="end">
                    <!--<span class="demonstration" style="font-size: 14px;color: #8492a6;">显示总数</span>-->
                    <el-pagination @current-change="handleCurrentChange" :current-page.sync="cur_page" background layout="total,prev, pager, next" :total="total" :page-size="pagesize">
                    </el-pagination>
                </el-row>
            </div>
        </div>
        <addgoods v-if="addshow" :show.sync="addshow" @closedialog="addChange"></addgoods>
        <editgoods v-if="editshow" :show.sync="editshow" :goods_id.sync="goods_id" @closedialog="editChange"></editgoods>
    </div>
</template>

<script>
    import addgoods from './components/addgoods';
    import editgoods from './components/editgoods';
    import { getlist,getGoodsTag,getcategorylist,goodsdelete,modify } from "@/api/goods.js";
    export default {
        data() {
            return {
                tableData: [

                ],
                goodsTagOptions:[

                ],
                firstOptions: [

                ],
                secondOptions: [

                ],
                goods_name:'',
                first_category_id:'',
                second_category_id:'',
                seller_name:'',
                shop_name:'',
                goods_tag:'',
                status:'',
                total:0,
                pagesize:10,
                cur_page: 1,
                addshow:false,
                editshow:false,
                goods_id:'',
            }
        },
        created(){
            this.getData();
            this.firstCategory();
            this.goodsTag();
        },
        components: {
            addgoods,
            editgoods,
        },
        mounted() {

        },
        methods: {
            addpt(){
                this.addshow = true;
            },
            editpt(goods_id){
                this.goods_id = goods_id;
                this.editshow = true;
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                getlist(this.cur_page,this.pagesize,this.goods_name,this.first_category_id,this.second_category_id,this.seller_name,this.shop_name,this.goods_tag,this.status).then(res => {
//                    console.log(res.data.data);
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
            formatStatus(row, column, cellValue){
                if (cellValue === 1){
                    return '上架';
                }else if (cellValue === 0){
                    return '下架';
                }
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
            deletegoods(goods_id) {
                const _this = this;
                goodsdelete(goods_id).then(res => {
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
            },
            firstCategory(){
                getcategorylist(0).then(res => {
//                    console.log(res.data.data.data)
                    this.firstOptions = res.data.data.data;
                }).catch(err => {
                    console.log(error)
                })
            },
            secondCategory(parent_id){
//                console.log(parent_id)
                getcategorylist(parent_id).then(res => {
                    console.log(res.data.data.data)
                    this.secondOptions = res.data.data.data;
                }).catch(err => {
                    console.log(error)
                })
            },
            goodsTag(){
                getGoodsTag().then(res => {
//                    console.log(res.data.data)
                    this.goodsTagOptions = res.data.data;
                }).catch (err => {
                    console.log(error)
                })
            },
        }
    }
</script>
