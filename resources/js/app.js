import './bootstrap';
import app from './App.vue'
import router from './router'
import { createApp } from 'vue';
import { vuetify } from './vuetify';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import { createPinia } from 'pinia'
const pinia = createPinia()

createApp(app)
.use(router)
.use(vuetify)
.use(ElementPlus)
.use(pinia)
.mount('#app')

