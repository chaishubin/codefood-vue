<template>
  <div id="addCategory">
    <el-dialog width="80%" top="5vh" :before-close="BcloseDialog" title="添加分类" :visible.sync="dialogFormVisible" :close-on-click-modal="false"
      :lock-scroll="true">
      <el-form :model="form" :rules="rules" ref="addForm">
        <el-row type="flex">
          <el-col :span="10" :offset="2">
            <el-form-item label="分类名称" prop="name">
              <el-input v-model="form.name" auto-complete="off" placeholder="20字以内" style="width:75%;"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="上级分类" prop="parent_id">
              <el-select v-model="form.parent_id" placeholder="请选择" style="width:75%;">
                <el-option v-for="item in options" :key="item.category_id" :label="item.name" :value="item.category_id"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="10" :offset="2">
            <el-form-item label="排序" prop="sort">
              <el-input-number size="large" v-model="form.sort" controls-position="right" :min="0"></el-input-number>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="状态" prop="status">
              <el-select v-model="form.status" placeholder="请选择" style="width:75%;">
                <el-option label="正常" value="1"></el-option>
                <el-option label="禁用" value="0"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="6" :offset="2">
            <el-form-item label="分类图片" prop="icon">
              <el-upload class="avatar-uploader" :action="imgurl" accept="image/jpeg,image/gif,image/png"
                :show-file-list="false" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload">
                <img v-if="form.icon" :src="form.icon" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
              </el-upload>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closechild('addForm')">取 消</el-button>
        <el-button type="primary" @click.native.prevent="submitform">保 存</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
    import { getcategoryparentlist,addmodify } from "@/api/productCategories.js"
    export default{
        data() {
            const words_20 = (rule, value, callback) => {
                if (value == '') {
                    callback(new Error("不能为空！"));
                } else {
                    if (value.length > 20) {
                        callback(new Error("字数过多！"));
                    } else {
                        callback();
                    }
                }
            };
            const selectempty = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("不能为空！"));
                } else {
                    callback();
                }
            };
            const imgempty = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("请上传图片！"));
                } else {
                    callback();
                }
            };  
            return {
                dialogFormVisible:this.show,
                imgurl:process.env.BASE_API + '/overseas/uploadImg',
                baseurl:process.env.IMG_API,
                options: [
                  {
                    "category_id":'0',
                    "name":"顶级分类"
                  }
                ],
                form: {
                    name:'',
                    parent_id:'', 
                    sort:'50',
                    status:'',
                    icon:'',
                    icon_show:'',
                },
                rules: {
                    name: [{required: true, trigger: "blur", validator: words_20}],
                    parent_id: [{required: true, trigger: "change", validator: selectempty}],
                    status: [{required: true, trigger: "change", validator: selectempty}],
                    icon: [{required: true, trigger: "blur", validator: imgempty}],
                },
            }
        },
        props: [
            'show'
        ],
        created() {
          this.firstCategory();
        },
        watch: {
            show () {
                this.dialogFormVisible = this.show;
            },
        },
        methods: {
          //表单提交
          submitform() {
              const _this = this; 
              this.$refs.addForm.validate(valid => {
                  console.log(valid)
                  if(valid){
                      addmodify(this.form.parent_id,this.form.name,this.form.icon,this.form.sort,this.form.status).then(res => {
                          console.log(res)
                          if(res.data.status == '200'){
                              this.$message({
                                  showClose: true,
                                  message: res.data.msg,
                                  type: 'success'
                              });
                              _this.BcloseDialog();
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
                  }else{
                      this.$message({
                          showClose: true,
                          message: '提交数据错误',
                          type: 'error'
                      });
                  }
                  
              });
          },
          //表单取消
          closechild(formName) {
            this.$nextTick(function() {
                this.$refs[formName].resetFields();
                this.$emit('closedialog',false); 
            })   
          },
          //dialog关闭前执行
          BcloseDialog(done){
              this.$nextTick(function() {
                  this.$refs['addForm'].resetFields();
                  this.$emit('closedialog',false); 
              }) 
              done();
          },
          //图片上传
          handleAvatarSuccess(res, file) {
              //this.form.list_img = URL.createObjectURL(file.raw);
              console.log(res)
              //this.form.icon_show = this.baseurl + res.data;
              this.form.icon = res.data;
              console.log(this.form.icon)
          },
          beforeAvatarUpload(file) {
              const isJPG = file.type === 'image/jpeg';
              const isGIF = file.type === 'image/gif';
              const isPNG = file.type === 'image/png';
              const isLt2M = file.size / 1024 / 1024 < 2;
              if (!isJPG && !isGIF && !isPNG ) {
                  this.$message.error('上传图片必须是JPG/GIF/PNG 格式!');
              }
              if (!isLt2M) {
              this.$message.error('上传头像图片大小不能超过 2MB!');
              }
              return (isJPG || isGIF || isPNG) && isLt2M;
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
        }
    }
</script>
<style>
  #addCategory .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 178px;
  }

  #addCategory .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }

  #addCategory .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 100%;
    height: 100%;
    line-height: 178px;
    text-align: center;
  }

  #addCategory .avatar {
    width: 100%;
    height: 100%;
    display: block;
  }

</style>
