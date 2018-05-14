<template>
    <div class="test">
        <div id="editor" style="height:500px;"></div>
    </div>
</template>
<script>
    export default{
        data () {
            return {
                editor:null,
                editorcontent:''
            }
        },
        props: [
            'editorshow',
        ],
        watch: {
            editorshow() {
                var _this = this;
                if(!this.editorshow){
                    _this.editor.setContent('');
                }
            },
        },
        created(){
            
        },
        mounted() {
    　　    this.initeditor();
            this.listeneditor();
            //this.settext();
        },
        destroyed(){
            this.editor.destroy();
        },
        methods: {
            geteditorcontent(data){
                console.log(data)
                var _this = this;
                this.editor.setContent(data)
            },
            initeditor(){
                this.editor = UE.getEditor('editor',{
                    wordCount:false
                });
            },
            destoryeditor(){
                this.editor.destroy();
            },
            gettext(){
                console.log(this.editor.getContent())
                this.editorcontent = this.editor.getContent();
                this.$emit('editorgoodsdesc',this.editorcontent); 
            },
            settext(data){
                var _this = this;
                this.editor.addListener("ready", function () {
                    // editor准备好之后才可以使用
                    _this.editor.setContent(data)
                });
            },
            listeneditor(){
                var _this = this;
                this.editor.addListener("contentChange",function(){
                    _this.gettext()
                }); 
            }
        }
    }
</script>