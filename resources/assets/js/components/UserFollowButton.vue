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
    props:['user'],

    // mounted 方法为钩子，在Vue实例化后自动调用
    mounted() {

       axios.get('/api/user/followers/' + this.user).then((response) => {
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
           return this.followed ? '已关注' : '关注Ta';
        }
    },
    methods:{

        // 关注动作
        follow(){
            axios.post('/api/user/follow', {
                'user':this.user
            }).then((response) => {
                this.followed = response.data.followed;
            })
        }
    }
}
</script>
