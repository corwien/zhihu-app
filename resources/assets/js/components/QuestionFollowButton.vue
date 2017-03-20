<template>
    <button
    class="btn btn-default"
    v-bind:class="{'btn-success':followed}"
    v-text="text"
    v-on:click="follow"
    >
    </button>
</template>

<script>
export default {

    // 为父组件传递到子组件的属性值，子组件使用props方法接收
    props:['question', 'user'],

    // mounted 方法为钩子，在Vue实例化后自动调用
    mounted() {

       /**  这种旧的写法会在Laravel5.4中报错
        this.$http.post('/api/question/follower', {'question':this.question, 'user':this.user}).then(response => {
            console.log(response.data);
        })
        */
       axios.post('/api/question/follower', {
           'question':this.question,
           'user':this.user
       }).then(function(response){
           // console.log(response.data);
           this.followed = response.data.followed;
       })
    },
    data(){
        return {
            followed : false,
        }
    },
    computed:{
        text(){
           return this.followed ? '已关注' : '关注该问题';
        }
    },
    methods:{

        // 关注动作
        follow(){
            axios.post('/api/question/follow', {
                'question':this.question,
                'user':this.user
            }).then(function(response){
                this.followed = response.data.followed;
            })
        }
    }
}
</script>
