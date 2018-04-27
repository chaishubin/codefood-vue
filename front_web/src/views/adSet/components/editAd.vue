<template>
  <div id="adEdit">
    <el-dialog width="80%" top="5vh" :before-close="BcloseDialog" title="编辑广告" :visible.sync="dialogFormVisible" :close-on-click-modal="false"
      :lock-scroll="true">
      <el-form :model="form" :rules="rules" ref="editForm">
        <el-row type="flex">
          <el-col :span="10" :offset="2">
            <el-form-item label="广告名称" prop="name">
              <el-input v-model="form.name" auto-complete="off" placeholder="20字以内" style="width:75%;"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="广告位置" prop="position">
              <el-select v-model="form.position" clearable placeholder="请选择" style="width:75%;">
                <el-option v-for="item in positionOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="10" :offset="2">
            <el-form-item label="广告分类" prop="category_id">
              <el-select v-model="form.category_id" clearable placeholder="请选择" style="width:75%;">
                <el-option v-for="item in categoryOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="排序" prop="sort">
              <el-input-number size="large" v-model="form.sort" controls-position="right" :min="0"></el-input-number>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="10" :offset="2">
            <el-form-item label="状态" prop="status">
              <el-select v-model="form.status" clearable placeholder="请选择" style="width:75%;">
                <el-option label="正常" value="1"></el-option>
                <el-option label="禁用" value="0"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="开始日期" prop="lifecycle">
              <el-date-picker
              @change="changetime"
              format="yyyy-MM-dd"
              v-model="form.lifecycle"
              type="daterange"
              range-separator="至"
              start-placeholder="开始日期"
              end-placeholder="结束日期">
              </el-date-picker>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="20" :offset="2">
            <el-form-item label="广告链接" prop="url">
              <el-input v-model="form.url" auto-complete="off" style="width:75%;"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="20" :offset="2">
            <el-form-item label="选择平台" prop="platform">
              <el-checkbox :indeterminate="form.isIndeterminate" v-model="form.checkAll" @change="handleCheckAllChange">全选</el-checkbox>
              <el-checkbox-group v-model="form.platform" @change="handleCheckedCitiesChange">
                <el-checkbox v-for="item in form.platformOptions" :label="item.id" :key="item.id">{{item.name}}</el-checkbox>
              </el-checkbox-group>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row type="flex">
          <el-col :span="6" :offset="2">
            <el-form-item label="广告图片" prop="img">
              <el-upload class="avatar-uploader" :action="imgurl" :show-file-list="false" :on-success="handleAvatarSuccess"
                :before-upload="beforeAvatarUpload">
                <img v-if="form.img" :src="form.img" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
              </el-upload>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closechild('editForm')">取 消</el-button>
        <el-button type="primary" @click.native.prevent="submitform">保 存</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
    import { platformlist,editbanner,getbannerdetail,bannerposition,categorylist } from '@/api/adSet.js'
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
            const urlempty = (rule,value,callback) => {
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
            const timeempty = (rule,value,callback) => {
                if(value.length == 0){
                    callback(new Error("请选择时间！"));
                } else {
                    callback();
                }
            };
            const platformempty = (rule,value,callback) => {
                if(value.length == 0){
                    callback(new Error("请选择平台！"));
                } else {
                    callback();
                }
            };
            return {
                categoryOptions: [

                ],
                positionOptions: [

                ],
                dialogFormVisible:this.show,
                imgurl:process.env.BASE_API + '/overseas/uploadImg',
                baseurl:process.env.IMG_API,
                form: {
                    name:'',
                    position:'',
                    category_id:'',
                    sort:'50',
                    status:'',
                    lifecycle:[],
                    url:'',
                    img:'',
                    img_show:'',
                    checkAll: false,
                    platform: [],
                    platformOptions: [],
                    isIndeterminate: false,
                },
                rules: {
                    name: [{required: true, trigger: "blur", validator: words_20}],
                    position: [{required: true, trigger: "change", validator: selectempty}],
                    category_id: [{required: true, trigger: "change", validator: selectempty}],
                    status: [{required: true, trigger: "change", validator: selectempty}],
                    url: [{required: true, trigger: "blur", validator: urlempty}],
                    img: [{required: true, trigger: "change", validator: imgempty}],
                    lifecycle: [{required: true, trigger: "blur", validator: timeempty}],
                    platform: [{required: true, trigger: "blur", validator: platformempty}],
                },
            }
        },
        props: [
            'show',
            'id'
        ],
        created(){
            this.getPositionList();
            this.getCategoryList();
            this.getPlatFormList();
            this.getInfo();
        },
        watch: {
            show () {
                this.dialogFormVisible = this.show;
            },
        },
        methods: {
            //获取商品信息
            getInfo() {
                const _this = this; 
                getbannerdetail(this.id).then(res => {
                    console.log(res)
                    if(res.data.status == '200'){
                        _this.form.name = res.data.data.name;
                        _this.form.position = res.data.data.position;
                        _this.form.category_id = res.data.data.category_id;
                        _this.form.sort = res.data.data.sort;
                        _this.form.status = res.data.data.status;
                        _this.form.lifecycle = res.data.data.lifecycle;
                        _this.form.url = res.data.data.url;
                        _this.form.img = res.data.data.img;
                        _this.form.img_show = _this.baseurl + res.data.data.img;
                        _this.form.platform = res.data.data.platform;
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
            //表单提交
            submitform() {
              const _this = this; 
              this.$refs.editForm.validate(valid => {
                  console.log(valid)
                  if(valid){
                      editbanner(this.id,this.form.name,this.form.platform,this.form.position,this.form.category_id,this.form.sort,this.form.status,this.form.lifecycle,this.form.url,this.form.img).then(res => {
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
                    this.$refs['editForm'].resetFields();
                    this.$emit('closedialog',false); 
                }) 
                done();
            },
            changetime(val){
                this.form.time = val;
                console.log(this.form.time);
            },
            //全选
            handleCheckAllChange(val) {
                console.log(val) 
                if(val){
                  var _this = this;
                  for(var i = 0; i < this.form.platformOptions.length; i++){
                    this.form.platform.push(_this.form.platformOptions[i].id)
                  }
                }else{
                  this.form.platform = [];
                }
                this.form.isIndeterminate = false;
            },
            handleCheckedCitiesChange(value) {
                console.log(value)
                let checkedCount = value.length;
                this.form.checkAll = checkedCount === this.form.platformOptions.length;
                this.form.isIndeterminate = checkedCount > 0 && checkedCount < this.form.platformOptions.length;
            },
            //图片上传
            handleAvatarSuccess(res, file) {
                //this.form.list_img = URL.createObjectURL(file.raw);
                console.log(res)
                //this.form.img_show = this.baseurl + res.data;
                this.form.img = res.data;
                console.log(this.form.img)
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
            //获取平台列表
            getPlatFormList() {
              platformlist().then(res => {
                  console.log(res.data)
                  this.form.platformOptions = res.data.data;
                  console.log(this.form.platformOptions)
              }).catch(err => {
                  console.log(err)
              })
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
        }
    }
</script>
<style>
    #adEdit .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        width:100%;
        height:178px;
    }
    #adEdit .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    #adEdit .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width:100%;
        height:100%;
        line-height: 178px;
        text-align: center;
    }
    #adEdit .avatar {
        width:100%;
        height:100%;
        display: block;
    }
</style>