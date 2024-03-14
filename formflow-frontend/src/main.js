import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Vue3ConfirmDialog from 'vue3-confirm-dialog'
import 'vue3-confirm-dialog/style'

createApp(App).use(store).use(router).use(Vue3ConfirmDialog).mount('#app')
