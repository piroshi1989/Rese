import StarRating from 'vue-star-rating'
Vue.component('star-rating', StarRating);
const app = new Vue({
    el: '#star',
    data: {
        rating: 0
    }
});