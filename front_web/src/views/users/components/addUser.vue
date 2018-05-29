<template>
    <div id="adduser">
        <div class="formwarp">
            <el-dialog width="80%" top="5vh" :before-close="BcloseDialog" title="添加用户" :visible.sync="dialogFormVisible" :close-on-click-modal="false"
                       :lock-scroll="true">
                <el-form :model="form" :rules="rules" ref="addForm">
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="姓名" prop="name">
                                <el-input v-model="form.name" auto-complete="off" placeholder="" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="微信open_id" prop="open_id">
                                <el-input type="text" v-model="form.open_id" placeholder="" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="电话" prop="tel">
                                <el-input v-model="form.tel" auto-complete="off" placeholder="" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="邮　　箱" prop="email">
                                <el-input v-model="form.email" auto-complete="off" placeholder="" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="密码" prop="password">
                                <el-input v-model="form.password" auto-complete="off" placeholder="20字以内" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="密码确认" prop="password_confirmation">
                                <el-input v-model="form.password_confirmation" auto-complete="off" placeholder="数字" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="状态" prop="status">
                                <el-select v-model="form.status" clearable placeholder="请选择" style="width:75%;">
                                    <el-option label="启用" value="1"></el-option>
                                    <el-option label="禁用" value="0"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="6" :offset="2">
                            <el-form-item label="头像" prop="icon">
                                <el-upload class="avatar-uploader" :action="imgurl" accept="image/jpeg,image/gif,image/png"
                                           :show-file-list="false" :on-success="userIconSuccess" :before-upload="beforeAvatarUpload">
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
    </div>
</template>

<script>
    import { adduser } from "@/api/user.js";
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
                    callback(new Error("请上传产品图！"));
                } else {
                    callback();
                }
            };
            const email = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("不能为空！"));
                }
            };
            const password = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("不能为空！"));
                }
            };
            const confirm_pass = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("不能为空！"));
                }
            };
            const mobile = (rule,value,callback) => {
                if(value == ''){
                    callback(new Error("不能为空！"));
                } else {
                    if(!Number.isInteger(Number(value))){
                        callback(new Error("手机号格式不正确"));
                    }else{
                        callback();
                    }
                }
            };
            return {
                dialogFormVisible :this.show,
                imgurl:process.env.BASE_API + '/manage/uploadImg',
                baseurl:process.env.IMG_API,
                firstOptions: [

                ],
                secondOptions: [

                ],
                goodsTagOptions: [

                ],
                form: {
                    name:'',
                    open_id:'',
                    tel:'',
                    email:'',
                    password:'',
                    password_confirmation:'',
                    status:'',
                    icon:''
                },
                rules: {
                    name: [{required: true, trigger: "blur", validator: words_20}],
                    open_id: [{required: false, trigger: "blur"}],
                    tel: [{required: true, trigger: "blur", validator: mobile}],
                    email: [{required: false, trigger: "blur", validator: email}],
                    password: [{required: true, trigger: "blur", validator: password}],
                    password_confirmation: [{required: true, trigger: "blur", validator: confirm_pass}],
                    status: [{required: true, trigger: "change", validator: selectempty}],
                    icon: [{required: false, trigger: "change", validator: imgempty}]
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
//            this.firstCategory();
//            this.goodsTag();
        },
        mounted() {

        },
        methods: {
            //表单提交
            submitform() {
                const _this = this;
//                this.$refs.addForm.validate(valid => {
//                    if(valid){
                        adduser(this.form.name,this.form.tel,this.form.password,this.form.password_confirmation,this.form.email,this.form.icon,this.form.status,this.form.open_id).then(res => {
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
//                    }else{
//                        this.$message({
//                            showClose: true,
//                            message: '提交数据错误',
//                            type: 'error'
//                        });
//                    }
//                });
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
            userIconSuccess(res,file,fileList) {
                //this.form.list_img = URL.createObjectURL(file.raw);
                console.log(res)
                this.form.icon = this.baseurl + res.data;
                //this.form.list_img_show = this.baseurl + res.data;
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
            }
        }
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
    #adduser {
        overflow: hidden;
        position: relative;
    }

    .formwarp {
        height: 100%;
    }

</style>
