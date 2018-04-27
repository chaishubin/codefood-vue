<template>
    <div id="editproduct">
        <div class="formwarp">
            <el-dialog width="80%" top="5vh" :before-close="BcloseDialog" title="编辑产品" :visible.sync="dialogFormVisible" :close-on-click-modal="false">
                <el-form :model="form" :rules="rules" ref="editForm">
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="产品分类" prop="first_category_id">
                                <el-select v-model="form.first_category_id" placeholder="请选择" style="width:75%;" @change="secondCategory(form.first_category_id)">
                                    <el-option v-for="item in firstOptions" :key="item.value" :label="item.name" :value="item.category_id"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="二级分类" prop="second_category_id">
                                <el-select v-model="form.second_category_id" placeholder="请选择" style="width:75%;">
                                    <el-option v-for="item in secondOptions" :key="item.value" :label="item.name" :value="item.category_id"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="产品名称" prop="goods_name">
                                <el-input v-model="form.goods_name" auto-complete="off" placeholder="20字以内" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="产品描述" prop="goods_summary">
                                <el-input v-model="form.goods_summary" auto-complete="off" placeholder="30字以内" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="医疗机构" prop="hospital_name">
                                <el-input v-model="form.hospital_name" auto-complete="off" placeholder="20字以内" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="医院描述" prop="hospital_summary">
                                <el-input v-model="form.hospital_summary" auto-complete="off" placeholder="30字以内" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="国家/城市" prop="hospital_city">
                                <el-input v-model="form.hospital_city" auto-complete="off" placeholder="示例：法国-巴黎" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="销售价格" prop="sell_price">
                                <el-input v-model="form.sell_price" auto-complete="off" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="定金" prop="front_money">
                                <el-input v-model="form.front_money" auto-complete="off" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="关键字" prop="specialty">
                                <el-input v-model="form.specialty" auto-complete="off" placeholder="逗号分隔开" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="产品状态" prop="status">
                                <el-select v-model="form.status" placeholder="请选择" style="width:75%;">
                                    <el-option label="上架" value="1"></el-option>
                                    <el-option label="下架" value="0"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="分享标题" prop="share_title">
                                <el-input v-model="form.share_title" auto-complete="off" placeholder="20字以内" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="排序" prop="sort">
                                <el-input-number size="large" v-model="form.sort" controls-position="right" :min="0"></el-input-number> 
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="20" :offset="2">
                            <el-form-item label="分享描述" prop="share_content">
                                <el-input type="textarea" v-model="form.share_content" placeholder="50字以内" auto-complete="off" style="width:90%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="20" :offset="2">
                            <el-form-item label="是否热门" prop="is_hot">
                                <el-row type="flex">
                                    <el-col :span="2">
                                        <el-switch v-model="form.is_hot" active-value="1" inactive-value="0"></el-switch>
                                    </el-col>
                                    <el-col :span="4" v-if="isShowSort()">
                                        <span>排序</span>
                                        <el-input-number size="mini" v-model="form.hot_sort" controls-position="right" :min="0"></el-input-number> 
                                    </el-col>
                                </el-row>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="6" :offset="2">
                            <el-form-item label="产品分类" prop="goods_tag">
                                <el-select v-model="form.goods_tag" placeholder="请选择" style="width:80%;">
                                    <el-option label="请选择" value=""></el-option>
                                    <el-option label="无" value="0"></el-option>
                                    <el-option label="推荐产品" value="1"></el-option>
                                    <el-option label="新品上线" value="2"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="6" :offset="2">
                            <el-form-item label="产品列表图" prop="list_img">
                                <el-upload class="avatar-uploader" :action="imgurl" accept="image/jpeg,image/gif,image/png"
                                :show-file-list="false" :on-success="listimgSuccess" :before-upload="beforeAvatarUpload">
                                <img v-if="form.list_img" :src="form.list_img" class="avatar">
                                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6" :offset="2">
                            <el-form-item label="产品主图" prop="main_img">
                                <el-upload class="avatar-uploader" :action="imgurl" :show-file-list="false" :on-success="mainimgSuccess"
                                :before-upload="beforeAvatarUpload">
                                <img v-if="form.main_img" :src="form.main_img" class="avatar">
                                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6" :offset="2" v-if="isShowSort()">
                            <el-form-item label="热门产品图" prop="hot_img">
                                <el-upload class="avatar-uploader" :action="imgurl" :show-file-list="false" :on-success="hotimgSuccess"
                                :before-upload="beforeAvatarUpload">
                                <img v-if="form.hot_img" :src="form.hot_img" class="avatar">
                                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="20" :offset="2">
                            <el-form-item label="产品详情" prop="goods_desc">

                            </el-form-item>
                            <editor ref="editeditor" :editorshow.sync="show" @editorgoodsdesc="editorgoodsdesc"></editor>
                        </el-col>
                    </el-row>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="closechild('editForm')">取 消</el-button>
                    <el-button type="primary" @click.native.prevent="submitform">保 存</el-button>
                </div>
            </el-dialog>
        </div>
    </div>
</template>

<script>
    import editor from './editor.vue';
    import { editproduct,getcategorylist,getgoodsinfo } from "@/api/healthcareInternational.js";
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
            const words_30 = (rule, value, callback) => {
                if (value == '') {
                    callback(new Error("不能为空！"));
                } else {
                    if (value.length > 30) {
                        callback(new Error("字数过多！"));
                    } else {
                        callback();
                    }
                }
            };
            const words_50 = (rule, value, callback) => {
                if (value == '') {
                    callback(new Error("不能为空！"));
                } else {
                    if (value.length > 50) {
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
            const validationprise = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("不能为空！"));
                } else {
                    if(!Number.isInteger(Number(value))){
                        callback(new Error("请输入数字值！"));
                    } else {
                        if(value < 0){
                            callback(new Error("钱数不能小于0！"));
                        }else{
                            callback();
                        }
                    }
                }
            };
            const imgempty = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("请上传产品！"));
                } else {
                    callback();
                }
            };
            const hotimg = (rule,value,callback) => {
                if(this.form.is_hot){
                  if(value == ''){
                      callback(new Error("请上传热门产品图！"));
                  } else {
                      callback();
                  }
                }else{
                  callback();
                }
            };
            const editorempty = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("产品详情不能为空！"));
                } else {
                    callback();
                }
            };
            return {
                dialogFormVisible :this.show,
                imgurl:process.env.BASE_API + '/overseas/uploadImg',
                baseurl:process.env.IMG_API,
                firstOptions: [

                ],
                secondOptions: [

                ],
                form: {
                    first_category_id:'',
                    second_category_id:'',
                    goods_name:'',
                    goods_summary:'',
                    hospital_name:'',
                    hospital_summary:'',
                    hospital_city:'',
                    sell_price:'',
                    front_money:'',
                    specialty:'',
                    status:'',
                    share_title:'',
                    sort:'',
                    share_content:'',
                    is_hot:false,
                    goods_tag:'',
                    hot_sort:'',
                    list_img:'',
                    main_img:'',
                    hot_img:'',
                    goods_desc:''
                },
                rules: {
                    first_category_id: [{required: true, trigger: "change", validator: selectempty}],
                    second_category_id: [{required: true, trigger: "change", validator: selectempty}],
                    goods_name: [{required: true, trigger: "blur", validator: words_20}],
                    goods_summary: [{required: false, trigger: "blur"}],
                    hospital_name: [{required: true, trigger: "blur", validator: words_20}],
                    hospital_summary: [{required: false, trigger: "blur"}],
                    sell_price: [{required: true, trigger: "blur", validator: validationprise}],
                    front_money: [{required: true, trigger: "blur", validator: validationprise}],
                    status: [{required: true, trigger: "change", validator: selectempty}],
                    share_title: [{required: true, trigger: "blur", validator: words_20}],
                    share_content: [{required: true, trigger: "blur", validator: words_50}],
                    sort: [{required: true, trigger: "blur"}],
                    hot_sort: [{required: false, trigger: "blur"}],
                    hospital_city: [{required: false, trigger: "blur"}],
                    specialty: [{required: false, trigger: "blur"}],
                    goods_tag: [{required: false, trigger: "change"}],
                    is_hot: [{required: false, trigger: "change"}],
                    list_img: [{required: true, trigger: "change", validator: imgempty}],
                    main_img: [{required: true, trigger: "change", validator: imgempty}],
                    hot_img: [{required: false, trigger: "change", validator: hotimg}],
                    goods_desc: [{required: true, trigger: "blur", validator: editorempty}]
                },
            }
        },
        components:{
            editor
        },
        props: [
            // show: {
            //     type: Boolean,
            //     default: false
            // },
            // id: {
            //     type: string
            // }
            'show',
            'id'
        ],
        watch: {
            show () {
                console.log(this.show)
                this.dialogFormVisible = this.show;
                if(this.show){
                    this.getInfo();
                }
            },
        },
        created(){
            this.firstCategory();
            this.getInfo();
        },
        mounted() {
            
	    },
        methods: {
            //获取商品信息
            getInfo() {
                const _this = this; 
                getgoodsinfo(this.id).then(res => {
                    console.log(res)
                    if(res.data.status == '200'){
                        _this.form.first_category_id = res.data.data.first_category_id;
                        _this.form.second_category_id = res.data.data.second_category_id;
                        _this.form.goods_name = res.data.data.goods_name;
                        _this.form.goods_summary = res.data.data.goods_summary;
                        _this.form.hospital_name = res.data.data.hospital_name;
                        _this.form.hospital_summary = res.data.data.hospital_summary;
                        _this.form.hospital_city = res.data.data.hospital_city;
                        _this.form.sell_price = res.data.data.sell_price;
                        _this.form.front_money = res.data.data.front_money;
                        _this.form.specialty = res.data.data.specialty;
                        _this.form.status = res.data.data.status;
                        _this.form.share_title = res.data.data.share_title;
                        _this.form.sort = res.data.data.sort;
                        _this.form.share_content = res.data.data.share_content;
                        _this.form.is_hot = res.data.data.is_hot;
                        _this.form.goods_tag = res.data.data.goods_tag;
                        _this.form.hot_sort = res.data.data.hot_sort;
                        _this.form.list_img = res.data.data.list_img;
                        _this.form.main_img = res.data.data.main_img;
                        _this.form.hot_img = res.data.data.hot_img;
                        _this.form.goods_desc = res.data.data.goods_desc;
                        _this.$refs.editeditor.geteditorcontent(_this.form.goods_desc);
                        console.log(_this.form.main_img_show)
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
                        editproduct(this.id,this.form.first_category_id,this.form.second_category_id,this.form.goods_name,this.form.goods_summary,this.form.hospital_name,this.form.hospital_summary,this.form.hospital_city,this.form.sell_price,this.form.front_money,this.form.specialty,this.form.status,this.form.share_title,this.form.share_content,this.form.sort,this.form.is_hot,this.form.hot_sort,this.form.goods_tag,this.form.list_img,this.form.main_img,this.form.hot_img,this.form.goods_desc).then(res => {
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
                        });
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
                done;
            },
            //是否显示排序
            isShowSort() {
              if(this.form.is_hot == '1'){
                  return true;  
              }else{
                  this.form.hot_sort = '50';
                  return false;
              }
            },
            //图片上传
            listimgSuccess(res,file,fileList) {
              //this.form.list_img = URL.createObjectURL(file.raw);
              console.log(res)
              this.form.list_img = res.data;
              console.log(this.form.list_img)
            },
            mainimgSuccess(res,file,fileList) {
              this.form.main_img = res.data;
              console.log(this.form.main_img)
            },
            hotimgSuccess(res,file,fileList) {
              this.form.hot_img = res.data;
              console.log(this.form.hot_img)
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
                console.log(this.id)
                getcategorylist(0).then(res => {
                    console.log(res)
                    this.firstOptions = res.data.data;
                }).catch(err => {
                    console.log(error)
                })
            },
            secondCategory(parent_id){
                console.log(parent_id)
                getcategorylist(parent_id).then(res => {
                    console.log(res)
                    this.secondOptions = res.data.data;
                }).catch(err => {
                    console.log(error)
                })
            },
            //传editor值
            editorgoodsdesc(editorcontent) {
              this.form.goods_desc = editorcontent;
              console.log(this.form.goods_desc)
            }
        },
    }
</script>
<style>
    .formwarp .el-dialog{
        height:800px;
        overflow: auto;
    }
    .formwarp .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        width:100%;
        height:178px;
    }
    .formwarp .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .formwarp .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width:100%;
        height:100%;
        line-height: 178px;
        text-align: center;
    }
    .formwarp .avatar {
        width:100%;
        height:100%;
        display: block;
    }
</style>
