<template>
    <div id="addgoodscategory">
        <div class="formwarp">
            <el-dialog width="80%" top="5vh" :before-close="BcloseDialog" title="添加产品" :visible.sync="dialogFormVisible" :close-on-click-modal="false"
                       :lock-scroll="true">
                <el-form :model="form" :rules="rules" ref="addForm">
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="分类名称：" prop="category_name">
                                <el-input v-model.trim="form.category_name" auto-complete="off" placeholder="分类名称：" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10" :offset="2">
                            <el-form-item label="所属分类" prop="parent_category_id">
                                <el-select v-model="form.parent_category_id" clearable placeholder="请选择" style="width:75%;">
                                    <el-option label="一级分类" value="0"></el-option>
                                    <el-option v-for="item in parentOptions" :key="item.category_id" :label="item.category_name" :value="item.category_id"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="商家 ID ：" prop="seller_id">
                                <el-input v-model.trim="form.seller_id" auto-complete="off" placeholder="商家id：" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="分类状态：" prop="status">
                                <el-select v-model="form.status" clearable placeholder="请选择" style="width:75%;">
                                    <el-option label="上架" value="1"></el-option>
                                    <el-option label="下架" value="0"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="排　　序：" prop="sort">
                                <el-input v-model.trim="form.sort" auto-complete="off" placeholder="排序：" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="6" :offset="2">
                            <el-form-item label="分类图片" prop="category_img">
                                <el-upload class="avatar-uploader" :action="imgurl" accept="image/jpeg,image/gif,image/png"
                                           :show-file-list="false" :on-success="categoryImgSuccess" :before-upload="beforeAvatarUpload">
                                    <img v-if="form.category_img" :src="form.category_img" class="avatar">
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
    </div>
</template>

<script>
    import { addcategory,getParentCategoryList } from "@/api/goodsCategory.js";
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
            const number = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("不能为空！"));
                } else {
                    if(!Number.isInteger(Number(value))){
                        callback(new Error("格式不正确"));
                    }else{
                        callback();
                    }
                }
            };
            const imgempty = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("请上传产品图！"));
                } else {
                    callback();
                }
            };
            return {
                dialogFormVisible :this.show,
                imgurl:process.env.BASE_API + '/manage/uploadImg',
                baseurl:process.env.IMG_API,
                parentOptions: [

                ],
                form: {
                    category_name:'',
                    parent_category_id:'',
                    seller_id:'',
                    category_img:'',
                    status:'',
                    sort:'50',
                },
                rules: {
                    category_name: [{required: true, trigger: "blur", validator: words_20}],
                    parent_category_id: [{required: true, trigger: "change", validator: selectempty}],
                    seller_id: [{required: true, trigger: "blur", validator: number}],
                    category_img: [{required: true, trigger: "change", validator: imgempty}],
                    status: [{required: true, trigger: "change"}],
                    sort: [{required: false, trigger: "blur", validator: number}]
                },
            }
        },
        components:{
//            editor
        },
        props: {
            show: {
                type: Boolean,
                default: false
            }
        },
        watch: {
            show () {
                this.dialogFormVisible = this.show;
            },
        },
        created(){
            this.parentCategory();
        },
        mounted() {

        },
        methods: {
            //表单提交
            submitform() {
                const _this = this;
                this.$refs.addForm.validate(valid => {
                    console.log(valid)
                    if(valid){
                        addcategory(this.form.category_name,this.form.parent_category_id,this.form.seller_id,this.form.category_img,this.form.status,this.form.sort).then(res => {
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
                            console.log(error)
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
                    //this.$refs.addeditor.destoryeditor();
                    this.$emit('closedialog',false);
                })
                done;
            },
            //图片上传
            categoryImgSuccess(res,file,fileList) {
                //this.form.list_img = URL.createObjectURL(file.raw);
                console.log(res)
                this.form.category_img = this.baseurl + res.data;
                //this.form.list_img_show = this.baseurl + res.data;
                console.log(this.form.category_img)
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
            //渲染菜单
            parentCategory(){
                getParentCategoryList(0,152483126733365).then(res => {
                    console.log(res.data.data.data);
                    this.parentOptions = res.data.data.data;
                }).catch(err => {
                    console.log(error)
                })
            }
        },
    }
</script>
<style>
    .formwarp .el-dialog {
        height: 800px;
        overflow: auto;
    }

    .formwarp .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 178px;
    }

    .formwarp .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .formwarp .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 100%;
        height: 100%;
        line-height: 178px;
        text-align: center;
    }

    .formwarp .avatar {
        width: 100%;
        height: 100%;
        display: block;
    }

</style>
<style scoped>
    #addgoodscategory {
        overflow: hidden;
        position: relative;
    }

    .formwarp {
        height: 100%;
    }

</style>
