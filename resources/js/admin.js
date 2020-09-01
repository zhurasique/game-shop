Vue.component('form-platform', require('./components/admin/FormPlatform.vue').default);
Vue.component('form-category', require('./components/admin/FormCategory.vue').default);
Vue.component('form-game', require('./components/admin/FormGame.vue').default);

const formPlatform = new Vue({
    el: '#form-platform'
})

const formCategory = new Vue({
    el: '#form-category'
})

const formGame = new Vue({
    el: '#form-game'
})



