<template>
    <div id="editgoods">
        <div class="formwarp">
            <el-dialog width="80%" top="5vh" :before-close="BcloseDialog" title="编辑产品" :visible.sync="dialogFormVisible" :close-on-click-modal="false"
                       :lock-scroll="true">
                <el-form :model="form" :rules="rules" ref="addForm">
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="产品分类" prop="first_category_id">
                                <el-select v-model="form.first_category_id" clearable placeholder="请选择" style="width:75%;" @change="secondCategory(form.first_category_id)">
                                    <el-option v-for="item in firstOptions" :key="item.category_id" :label="item.category_name" :value="item.category_id"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="二级分类" prop="second_category_id">
                                <el-select v-model="form.second_category_id" clearable placeholder="请选择" style="width:75%;">
                                    <el-option v-for="item in secondOptions" :key="item.category_id" :label="item.category_name" :value="item.category_id"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="商家　id" prop="seller_id">
                                <el-input v-model="form.seller_id" auto-complete="off" placeholder="" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="产品名称" prop="goods_name">
                                <el-input v-model="form.goods_name" auto-complete="off" placeholder="" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="产品简介" prop="goods_summary">
                                <el-input v-model="form.goods_summary" auto-complete="off" placeholder="" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="售　　价" prop="sell_price">
                                <el-input v-model="form.sell_price" auto-complete="off" placeholder="20字以内" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="排　　序" prop="sort">
                                <el-input v-model="form.sort" auto-complete="off" placeholder="数字" style="width:75%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="产品状态" prop="status">
                                <el-select v-model="form.status" clearable placeholder="请选择" style="width:75%;">
                                    <el-option label="上架" value="1"></el-option>
                                    <el-option label="下架" value="0"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="是否热门" prop="is_hot">
                                <el-select v-model="form.is_hot" clearable placeholder="请选择" style="width:75%;">
                                    <el-option label="是" value="1"></el-option>
                                    <el-option label="否" value="0"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="产品标签" prop="goods_tag">
                                <el-select v-model="form.goods_tag" clearable placeholder="请选择" style="width:75%;">
                                    <el-option v-for="item in goodsTagOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="10" :offset="2">
                            <el-form-item label="分享标题" prop="share_title">
                                <el-input type="text" v-model="form.share_title" placeholder="50字以内" auto-complete="off" style="width:90%;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="分享描述" prop="share_content">
                                <el-input type="textarea" v-model="form.share_content" placeholder="50字以内" auto-complete="off" style="width:90%;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="6" :offset="2">
                            <el-form-item label="产品图" prop="goods_img">
                                <el-upload class="avatar-uploader" :action="imgurl" accept="image/jpeg,image/gif,image/png"
                                           :show-file-list="false" :on-success="goodsImgSuccess" :before-upload="beforeAvatarUpload">
                                    <img v-if="form.goods_img" :src="form.goods_img" class="avatar">
                                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row type="flex">
                        <el-col :span="20" :offset="2">
                            <el-form-item label="产品详情" prop="goods_desc">
                            </el-form-item>
                            <editor ref="addeditor" :editorshow.sync="show" @editorgoodsdesc="editorgoodsdesc"></editor>
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
    import editor from './editor.vue';
    import { getgoodsinfo,getcategorylist,editgoods,getGoodsTag } from "@/api/goods.js";
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
            const editorempty = (rule,value,callback) => {
                console.log(value)
                if(value == ''){
                    callback(new Error("产品详情不能为空！"));
                } else {
                    callback();
                }
            };
            const secondcategory = (rule,value,callback) => {
                if(value == ''){
                    this.form.second_category_id = ''
                    callback();
                } else {
                    callback();
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
                    first_category_id:'',
                    second_category_id:'',
                    seller_id:'',
                    goods_name:'',
                    goods_summary:'',
                    sell_price:'',
                    sort:'50',
                    status:'',
                    is_hot:'',
                    goods_tag:'',
                    share_title:'',
                    share_content:'',
                    goods_img:'',
                    goods_desc:''
                },
                rules: {
                    first_category_id: [{required: true, trigger: "change", validator: selectempty}],
                    second_category_id: [{required: false, trigger: "change", validator: secondcategory}],
                    seller_id: [{required: true, trigger: "blur"}],
                    goods_name: [{required: true, trigger: "blur", validator: words_20}],
                    goods_summary: [{required: true, trigger: "blur"}],
                    sell_price: [{required: true, trigger: "blur", validator: validationprise}],
                    sort: [{required: true, trigger: "blur"}],
                    status: [{required: true, trigger: "change", validator: selectempty}],
                    is_hot: [{required: true, trigger: "change"}],
                    goods_tag: [{required: false, trigger: "change"}],
                    share_title: [{required: true, trigger: "blur", validator: words_20}],
                    share_content: [{required: true, trigger: "blur", validator: words_50}],
                    goods_img: [{required: true, trigger: "blur", validator: imgempty}],
                    goods_desc: [{required: false, trigger: "blur", validator: editorempty}]
                },
            }
        },
        components:{
            editor
        },
        props: [
//            show: {
//                type: Boolean,
//                default: false,
//            }
            'show',
            'goods_id'
        ],
        watch: {
            show () {
                console.log(this.goods_id)
                console.log(this.show)
                this.dialogFormVisible = this.show;
                if(this.show){
                    this.getInfo();
                }
            },
        },
        created(){
            this.getInfo();
            this.firstCategory();
            this.goodsTag();
        },
        mounted() {

        },
        methods: {
            //获取商品信息
            getInfo() {
               console.log(this.goods_id)
                const _this = this;
                getgoodsinfo(this.goods_id).then(res => {
                    console.log(res.data.data;)
                    var result = res.data.data;
                    _this.form.first_category_id = 

                }).catch(err => {
                    console.log(error)
                });
            },
            //表单提交
            submitform() {
                const _this = this;
                this.$refs.addForm.validate(valid => {
                    console.log(valid)
                    if(valid){
                        addgoods(this.form.first_category_id,this.form.second_category_id,this.form.seller_id,this.form.goods_name,this.form.goods_summary,this.form.sell_price,this.form.sort,this.form.status,this.form.is_hot,this.form.goods_tag,this.form.share_title,this.form.share_content,this.form.goods_img,this.form.goods_desc).then(res => {
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
            goodsImgSuccess(res,file,fileList) {
                //this.form.list_img = URL.createObjectURL(file.raw);
                console.log(res)
                this.form.goods_img = this.baseurl + res.data;
                //this.form.list_img_show = this.baseurl + res.data;
                console.log(this.form.goods_img)
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
            firstCategory(){
                getcategorylist(0).then(res => {
                    console.log(res.data.data.data);
                    this.firstOptions = res.data.data.data;
                }).catch(err => {
                    console.log(error)
                })
            },
            secondCategory(parent_id){
                console.log(parent_id)
                getcategorylist(parent_id).then(res => {
                    console.log(res.data.data.data)
                    this.secondOptions = res.data.data.data;
                }).catch(err => {
                    console.log(error)
                })
            },
            goodsTag(){
                getGoodsTag().then(res => {
                    console.log(res.data.data)
                    this.goodsTagOptions = res.data.data;
                }).catch(err => {
                    console.log(error)
                })
            },
            //传editor值
            editorgoodsdesc(editorcontent) {
                this.form.goods_desc = editorcontent;
                console.log(this.form.goods_desc)
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
    #editgoods {
        overflow: hidden;
        position: relative;
    }

    .formwarp {
        height: 100%;
    }

</style>
