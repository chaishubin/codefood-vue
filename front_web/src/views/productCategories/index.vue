<template>
  <div id="productCategories">
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
          <el-col :span="15">
            <el-form-item label="产品名称：">
              <el-input v-model.trim="name" placeholder="产品名称："></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="15">
            <el-form-item label="上级分类：">
              <el-select v-model="parent_id" clearable placeholder="请选择">
                <el-option v-for="item in options" :key="item.category_id" :label="item.name" :value="item.category_id"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="15">
            <el-form-item label="状态：">
              <el-select v-model="status" clearable placeholder="请选择">
                <el-option label="正常" value="1"></el-option>
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
        <el-table-column prop="name" label="分类名称">
        </el-table-column>
        <el-table-column prop="parent_category_name" label="上级分类">
        </el-table-column>
        <el-table-column prop="sort" label="排序">
        </el-table-column>
        <el-table-column prop="status" label="状态" :formatter="formatStatus">
        </el-table-column>
        <el-table-column label="操作" width="250">
          <template slot-scope="scope">
            <el-button size="small" @click="editpt(scope.row.category_id)">编辑</el-button>
            <el-button size="small" type="danger" @click="deletecategory(scope.row.category_id)">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <addcategory v-if="addshow" :show.sync="addshow" @closedialog="addChange"></addcategory>
    <editcategory v-if="editshow" :show.sync="editshow" :id.sync="id" @closedialog="editChange"></editcategory>
  </div>
</template>
<script>
    import addcategory from './components/addCategory.vue'
    import editcategory from './components/editCategory.vue'
    import { getlist,getcategoryparentlist,goodscategorydelete } from "@/api/productCategories.js"
    export default{
        data () {
            return {
                tableData:[
                    
                ],
                options: [
                  {
                    "category_id":'0',
                    "name":"顶级分类"
                  }
                ],
                total:0,
                name:'',
                parent_id:'',
                status:'',
                addshow:false,
                editshow:false,
                id:'',
            }
        },
        created() {
          this.getData();
          this.firstCategory();
        },
        components: {
          addcategory,
          editcategory
        },
        mounted() {

        },
        methods: {
          getData(){
            getlist(this.name,this.parent_id,this.status).then(res => {
                console.log(res.data.data)
                this.tableData = res.data.data;
            }).catch(err => {
                console.log(err)
            })
          },
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
          editpt(id){
              this.id = id;
              this.editshow = true;
          },
          editChange(){
              this.editshow = false;
              this.getData();
          },
          formatStatus(row, column, cellValue){
            if (cellValue === 1){
                return '正常';
            }else if (cellValue === 0){
                return '禁用';
            }
          },
          firstCategory(){
            getcategoryparentlist(0).then(res => {
              console.log(res.data.data)
              var optiondata = res.data.data;
              for(var i = 0;i<optiondata.length;i++){
                this.options.push(optiondata[i])
              }
            }).catch(err => {       
              console.log(err)
            })
          },
          deletecategory(category_id) {
            const _this = this;
            goodscategorydelete(category_id).then(res => {
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
