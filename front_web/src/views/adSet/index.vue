<template>
  <div id="adset">
    <div class="handle-box">
      <el-row type="flex" justify="end" style="margin-bottom:20px;">
        <el-col :span="2">
          <el-row type="flex" justify="end">
            <el-button type="primary" @click="addAd()">添加</el-button>
          </el-row>
        </el-col>
      </el-row>
      <el-form :inline="true" class="demo-form-inline" size="small">
        <el-row type="flex">
          <el-col :span="6">
            <el-form-item label="广告名称：">
              <el-input v-model.trim="name" placeholder="广告名称"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item label="选择平台：">
              <el-input v-model.trim="platform" placeholder="选择平台："></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item label="广告位置：">
              <el-select v-model="position" clearable placeholder="请选择">
                <el-option v-for="item in positionOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item label="广告分类：">
              <el-select v-model="category_id" clearable placeholder="请选择">
                <el-option v-for="item in categoryOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="6">
            <el-form-item label="状态：">
              <el-select v-model="status" clearable placeholder="请选择">
                <el-option label="启用" value="1"></el-option>
                <el-option label="禁用" value="0"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
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
        <el-table-column prop="banner_id" label="广告ID">
        </el-table-column>
        <el-table-column prop="name" label="广告名称">
        </el-table-column>
        <el-table-column prop="platform" :formatter="formatplatform" label="选择平台">
        </el-table-column>
        <el-table-column prop="position" :formatter="formatposition" label="广告位置">
        </el-table-column>
        <el-table-column prop="category_id" :formatter="formatcategory" label="广告分类">
        </el-table-column>
        <el-table-column prop="sort" label="排序">
        </el-table-column>
        <el-table-column prop="status" :formatter="formatstatus" label="状态">
        </el-table-column>
        <el-table-column label="操作" width="250">
          <template slot-scope="scope">
            <el-button size="small" @click="editpt(scope.row.banner_id)">编辑</el-button>
            <el-button size="small" type="danger" @click="deletbanner(scope.row.banner_id)">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination" style="margin:20px 0;">
        <el-row type="flex" align="middle" justify="end">
          <el-pagination @current-change="handleCurrentChange" background layout="total,prev, pager, next" :total="total" :page-size="pagesize">
          </el-pagination>
        </el-row>
      </div>
    </div>
    <addad v-if="addshow" :show.sync="addshow" @closedialog="addChange"></addad>
    <editad v-if="editshow" :show.sync="editshow" :id.sync="id" @closedialog="editChange"></editad>
  </div>
</template>
<script>
    import addad from './components/adAdd.vue'
    import editad from './components/editad.vue'
    import { getlist,bannerposition,categorylist,bannerDelete } from '@/api/adSet.js'
    export default{
        data () {
            return {
                categoryOptions: [

                ],
                positionOptions: [

                ],
                tableData:[
                       
                ],
                total:0,
                pagesize:10,
                cur_page: 1,
                name:'',
                platform:'',
                position:'',
                category_id:'',
                status:'',
                addshow:false,
                editshow:false,
                id:'',
            }
        },
        created() {
            this.getPositionList();
            this.getCategoryList();
            this.getData();
        },
        components: {
            addad,
            editad
        },
        mounted() {

        },
        methods: {
            addAd() {
                this.addshow = true;
            },
            addChange(){
                this.addshow = false;
                this.getData();
            },
            search(){   
              this.getData();
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                getlist(this.cur_page,this.pagesize,this.name,this.platform,this.position,this.category_id,this.status).then(res => {
                    console.log(res)
                    this.total = res.data.data.total;
                    this.tableData = res.data.data[0];
                }).catch(err => {
                    console.log(err)
                })
            },
            editpt(id){
                this.id = id;
                this.editshow = true;
            },
            editChange(){
                this.editshow = false;
                this.getData();
            },
            //获取广告分类菜单
            getCategoryList() {
              categorylist().then(res => {
                  this.categoryOptions = res.data.data;
              }).catch(err => {
                  console.log(err)
              })
            },
            //获取广告位置菜单
            getPositionList() {
              bannerposition().then(res => {
                  this.positionOptions = res.data.data;
              }).catch(err => {
                  console.log(err)
              })
            },
            //删除
            deletbanner(banner_id) {
              const _this = this;
              bannerDelete(banner_id).then(res => {
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
            formatplatform(row, column, cellValue) {
              let platformArr = new Array(); 
              let platformdescArr = new Array(); 
              platformArr = cellValue.split(",");
              for (let i=0;i<platformArr.length ;i++ ) { 
                if(platformArr[i] == '101'){
                  platformdescArr.push('APP-医生');
                }else if(platformArr[i] == '102'){
                  platformdescArr.push('APP-C端');
                }else if(platformArr[i] == '103'){
                  platformdescArr.push('WAP-H5');
                }
              }  
              return platformdescArr.join(',');
            },          
            formatposition(row, column, cellValue) {
              if (cellValue == '101'){
                return '首页';
              }
            },
            formatcategory(row, column, cellValue) {
              if (cellValue == '101'){
                return 'Banner';
              }
            },
            formatstatus(row, column, cellValue) {
              if (cellValue == '1'){
                return '正常';
              }else if(cellValue == '0'){
                return '禁用';
              }
            },
        },
    }
</script>
