<template>
    <div id="sellers">
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
                        <el-form-item label="商家姓名：">
                            <el-input v-model.trim="username" placeholder="商家姓名："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="店铺名称：">
                            <el-input v-model.trim="shop_name" placeholder="店铺名称："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="商家电话：">
                            <el-input v-model.trim="user_mobile" placeholder="商家电话："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="商家状态：">
                            <el-select v-model="status" clearable placeholder="请选择">
                                <el-option label="启用" value="1"></el-option>
                                <el-option label="禁用" value="0"></el-option>
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
                <el-table-column prop="id" label="商家id">
                </el-table-column>
                <el-table-column prop="username" label="商家姓名">
                </el-table-column>
                <el-table-column prop="user_mobile" label="商家电话">
                </el-table-column>
                <el-table-column prop="shop_name" label="店铺名称">
                </el-table-column>
                <el-table-column label="店铺头像">
                    <template scope="scope">
                        <img :src="scope.row.shop_logo" width="50" height="50"/>
                    </template>
                </el-table-column>
                <el-table-column prop="status" :formatter="formatStatus" label="商家状态">
                </el-table-column>
                <el-table-column label="操作" width="250">
                    <template slot-scope="scope">
                        <el-button v-if="scope.row.status === 0" size="small" @click="changeStatus(scope.row.id,1)">启用</el-button>
                        <el-button v-else-if="scope.row.status === 1" size="small" @click="changeStatus(scope.row.id,0)">禁用</el-button>
                        <el-button size="small" @click="editpt(scope.row.id)">编辑</el-button>
                        <el-button size="small" type="danger" @click="deleteseller(scope.row.id)">删除</el-button>
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
        <addseller v-if="addshow" :show.sync="addshow" @closedialog="addChange"></addseller>
        <editseller v-if="editshow" :show.sync="editshow" :id.sync="id" @closedialog="editChange"></editseller>
    </div>
</template>

<script>
    import addseller from './components/addSeller';
    import editseller from './components/editSeller';
    import { getlist,sellerdelete,modify } from "@/api/seller.js";
    export default {
        data() {
            return {
                tableData: [

                ],
                firstOptions: [

                ],
                secondOptions: [

                ],
                username:'',
                user_mobile:'',
                shop_name:'',
                shop_logo:'',
                status:'',
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
            addseller,
            editseller,
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
                getlist(this.cur_page,this.pagesize,this.user_mobile,this.username,this.shop_name,this.status,).then(res => {
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
            formatStatus(row, column, cellValue){
                if (cellValue === 1){
                    return '启用';
                }else if (cellValue === 0){
                    return '禁用';
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
            deleteseller(id) {
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
