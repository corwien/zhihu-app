
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// 注册Vue组件
 Vue.component('example', require('./components/Example.vue'));
 Vue.component('question-follow-button', require('./components/QuestionFollowButton.vue'));
 Vue.component('user-follow-button', require('./components/UserFollowButton.vue'));
 Vue.component('user-vote-button', require('./components/UserVoteButton.vue'));

// 发送私信Modal
 Vue.component('send-message', require('./components/SendMessage.vue'));

// 评论
 Vue.component('comments', require('./components/Comments.vue'));

// 设置头像
Vue.component('avatar', require('./components/Avatar.vue'));

const app = new Vue({
    el: '#app'
});
