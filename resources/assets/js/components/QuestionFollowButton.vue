<template>
    <button
    class="btn btn-default"
    v-text="text"
    ></button>
</template>

<script>
export default {
    props:['question', 'user'],
    mounted() {
        // console.log('Component mounted.')
        this.$http.post('/api/question/follower', {'question':this.question, 'user':this.user}).then(response => {
            console.log(response.data);
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
    }
}
</script>
