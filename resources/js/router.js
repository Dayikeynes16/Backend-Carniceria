import * as VueRouter from 'vue-router'
import Index from './Pages/Index.vue';

const routes = [{
    name: 'Index',
    path: '/',
    component: Index
}
]


const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
})
export default router  

