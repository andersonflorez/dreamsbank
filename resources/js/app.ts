import router from './router';
import Vue from 'vue'
import store from "./store"
import App from './views/App.vue'
import vuetify from './vuetify'
import Notifications from 'vue-notification'
Vue.use(Notifications)

store.dispatch('authStore/me').then(() => {
  new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
  }).$mount('#app')
})
