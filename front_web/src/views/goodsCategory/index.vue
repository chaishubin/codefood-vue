<template>
    <div id="goodsCategory">
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
                        <el-form-item label="分类名称：">
                            <el-input v-model.trim="category_name" placeholder="分类名称："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="上级分类名称：">
                            <el-input v-model.trim="parent_category_name" placeholder="上级分类名称："></el-input>
                        </el-form-item>
                    </el-col>
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
                <el-table-column prop="category_id" label="分类id">
                </el-table-column>
                <el-table-column prop="category_name" label="分类名称">
                </el-table-column>
                <el-table-column prop="seller_name" label="商家姓名">
                </el-table-column>
                <el-table-column prop="shop_name" label="店铺名称">
                </el-table-column>
                <el-table-column label="分类图标">
                    <template scope="scope">
                        <img :src="scope.row.category_img" width="50" height="50"/>
                    </template>
                </el-table-column>
                <el-table-column prop="status" :formatter="formatStatus" label="状态">
                </el-table-column>
                <el-table-column prop="sort" label="排序">
                </el-table-column>
                <el-table-column label="操作" width="250">
                    <template slot-scope="scope">
                        <el-button v-if="scope.row.status === 0" size="small" @click="changeStatus(scope.row.category_id,1)">上架</el-button>
                        <el-button v-else-if="scope.row.status === 1" size="small" @click="changeStatus(scope.row.category_id,0)">下架</el-button>
                        <el-button size="small" @click="editpt(scope.row.category_id)">编辑</el-button>
                        <el-button size="small" type="danger" @click="deletecategory(scope.row.category_id)">删除</el-button>
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
        <addcategory v-if="addshow" :show.sync="addshow" @closedialog="addChange"></addcategory>
        <editcategory v-if="editshow" :show.sync="editshow" :category_id.sync="category_id" @closedialog="editChange"></editcategory>
    </div>
</template>

<script>
    import addcategory from './components/addgoodscategory';
    import editcategory from './components/editGoodsCategory';
    import { getlist,categorydelete,modify } from "@/api/goodsCategory.js";
    export default {
        data() {
            return {
                tableData: [

                ],
                category_name:'',
                parent_category_name:'',
                seller_name:'',
                shop_name:'',
                status:'',
                total:0,
                pagesize:10,
                cur_page: 1,
                addshow:false,
                editshow:false,
                category_id:'',
            }
        },
        created(){
            this.getData();
        },
        components: {
            addcategory,
            editcategory,
        },
        mounted() {

        },
        methods: {
            addpt(){
                this.addshow = true;
            },
            editpt(category_id){
                this.category_id = category_id;
                this.editshow = true;
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                getlist(this.cur_page,this.pagesize,this.category_name,this.parent_category_name,this.seller_name,this.shop_name,this.status).then(res => {
                    console.log(res.data.data);
                    this.total = res.data.data.total;
                    this.tableData = res.data.data.data;
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
            changeStatus(category_id,status){
                modify(category_id,status).then(res => {
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
            deletecategory(category_id) {
                const _this = this;
                categorydelete(category_id).then(res => {
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
