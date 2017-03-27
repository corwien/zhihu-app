<template>
    <div>
        <button
        class="btn btn-default pull-right"
        style="margin-top: -36px;"
        v-on:click="showSendMessageForm"
    >发送私信</button>

        <div class="modal fade" id="modal-send-message" tabindex="-1" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h4 class="modal-title">
                发送私信
            </h4>
        </div>

        <div class="modal-body">
        <!-- 这里根据status的状态来区分是否显示提示文本框或提醒文字【20170316】 -->
          <textarea name="body" class="form-control" v-model="body" v-if="!status"></textarea>
          <div class="alert alert-success" v-if="status">
            <strong>私信发送成功</strong>
          </div>
        </div>

       <!-- Modal Actions -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            <button type="button" class="btn btn-primary" @click="store">发送</button>
        </div>
    </div>
    </div>
    </div>
    </div>

</template>

<script>
export default {

    // 为父组件传递到子组件的属性值，子组件使用props方法接收
    props:['user'],

    // 模型绑定数据
    data(){
        return {
            body : '',
            status:false
        }
    },
    methods:{

        // 发送私信动作
        store(){
            axios.post('/api/message/store', {
                'user':this.user, 'body':this.body
            }).then((response) => {

                // 这里根据返回的数据驱动是否隐藏输入框或显示提交成功的信息，
                // 使用Vue比以前单独用jQuery操作DOM来隐藏模态框更加便捷，简洁，也不用再使用alert弹出框了。
                this.status = response.data.status;

                // 清空内容
                this.body   = '';
                this.status = false;

                    // 延时消失提示信息
                setTimeout(function () {
                    // 显示发送消息后，关闭模态框
                    $('#modal-send-message').modal('hide');
                }, 2000);

            })
        },

        // jquery 点击事件，弹出模态框
        showSendMessageForm(){
           $('#modal-send-message').modal('show');

        }
    }
}
</script>
