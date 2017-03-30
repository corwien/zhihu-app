<template>
<div>
<button
class="button is-naked delete-button"
v-on:click="showCommentsForm"
        v-text="text"
    ></button>

    <div class="modal fade" :id=dialog tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
             <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

             <h4 class="modal-title">
               评论列表
             </h4>
          </div>

          <div class="modal-body">
               <div v-if="comments.length > 0">

                    <!-- 评论列表 -->
                    <div class="media" v-for="comment in comments">
                        <div class="media-left">
                            <a href="#">
                            <img width="36px" class="media-object" :src="comment.user.avatar">
                            </a>
                        </div>
                       <div class="media-body">
                        <h4 class="media-heading">{{ comment.user.name }}&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;{{ comment.created_at }}</h4>
                           {{ comment.body }}
                       </div>
                    </div>

               </div>
          </div>

         <!-- Modal Actions -->
         <div class="modal-footer">
           <input type="text" class="form-control" name="body" v-model="body">
            <button type="button" class="btn btn-primary" @click="store">评论</button>
         </div>
        </div>
      </div>
    </div>
    </div>

    </template>

    <script>
export default {

    // 为父组件传递到子组件的属性值，子组件使用props方法接收，model为question_id或answer_id
    props:['type', 'model', 'count'],

    // 模型绑定数据  Zhihu是定义在全局的变量，app.blade.php中
    data(){
        return {
            body : '',
            comments :[],
            newComment:{
                user:{
                    name:Zhihu.name,
                    avatar:Zhihu.avatar
                },
                body:''
            }
        }
    },

    // 在DOM加载时会调用该computed钩子
    computed:{
       dialog(){
           return 'comments-dialog-' + this.type + "-" + this.model;
       },
        dialogId(){
            return '#' + this.dialog;

        },
        text(){
            return this.count + '评论'
        }
    },
    methods:{

        // 发送私信动作
        store(){
            axios.post('/api/comment', {
                'type':this.type, 'model':this.model, 'body':this.body
            }).then((response) => {

                this.newComment.body = response.data.body
                this.comments.push(this.newComment)
                this.body = ''
                this.count ++

            })
        },
        getComments(){
            axios.get('/api/' + this.type + '/' + this.model + "/comments", {
            }).then((response) => {

                // 这里根据返回的数据驱动是否隐藏输入框或显示提交成功的信息，
                // 使用Vue比以前单独用jQuery操作DOM来隐藏模态框更加便捷，简洁，也不用再使用alert弹出框了。
                // console.log(response.data);

                this.comments = response.data;

            })
        },

        // jquery 点击事件，弹出模态框
        showCommentsForm(){
            this.getComments()
            $(this.dialogId).modal('show');

        }
    }
}
</script>
