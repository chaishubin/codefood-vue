<template>
    <div id="users">
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
                        <el-form-item label="用户姓名：">
                            <el-input v-model.trim="name" placeholder="用户姓名："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="电话：">
                            <el-input v-model.trim="tel" placeholder="电话："></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="微信open_id：">
                            <el-input v-model.trim="open_id" placeholder="微信open_id："></el-input>
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
                <el-table-column prop="id" label="用户id">
                </el-table-column>
                <el-table-column prop="name" label="用户姓名">
                </el-table-column>
                <el-table-column prop="tel" label="电话">
                </el-table-column>
                <el-table-column prop="email" label="邮箱">
                </el-table-column>
                <el-table-column label="头像">
                    <template scope="scope">
                        <img :src="scope.row.icon" width="50" height="50"/>
                    </template>
                </el-table-column>
                <el-table-column prop="open_id" label="微信open_id">
                </el-table-column>
                <el-table-column prop="last_login_ip" label="登陆ip">
                </el-table-column>
                <el-table-column prop="status" :formatter="formatStatus" label="状态">
                </el-table-column>
                <el-table-column label="操作" width="250">
                    <template slot-scope="scope">
                        <el-button v-if="scope.row.status === 0" size="small" @click="changeStatus(scope.row.id,1)">启用</el-button>
                        <el-button v-else-if="scope.row.status === 1" size="small" @click="changeStatus(scope.row.id,0)">禁用</el-button>
                        <el-button size="small" @click="editpt(scope.row.id)">编辑</el-button>
                        <el-button size="small" type="danger" @click="deleteuser(scope.row.id)">删除</el-button>
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
        <adduser v-if="addshow" :show.sync="addshow" @closedialog="addChange"></adduser>
        <edituser v-if="editshow" :show.sync="editshow" :id.sync="id" @closedialog="editChange"></edituser>
    </div>
</template>

<script>
    import adduser from './components/addUser';
    import edituser from './components/editUser';
    import { getlist,userdelete,modify } from "@/api/user.js";
    export default {
        data() {
            return {
                tableData: [

                ],
                firstOptions: [

                ],
                secondOptions: [

                ],
                name:'',
                tel:'',
                open_id:'',
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
            adduser,
            edituser,
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
                getlist(this.cur_page,this.pagesize,this.name,this.tel,this.open_id,this.status,).then(res => {
                    console.log(res.data.data)
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
            deleteuser(id) {
                const _this = this;
                userdelete(id).then(res => {
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
