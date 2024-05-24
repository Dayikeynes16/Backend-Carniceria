import * as VueRouter from 'vue-router'
import Index from './Pages/Index.vue'
import Ejemplo from './Pages/ejemplo3.vue'
import Cumpleaños from './Pages/Cumpleaños.vue'
import Register from './Pages/Register.vue'
import Cotizar from './Pages/Cotizacion.vue'
import Login from './Pages/Login.vue'

const routes = [{
    name: 'register',
    path: '/',
    component: Register
},{
    name:'cotizar',
    path: '/cotizar',
    component: Ejemplo
},{
    name:'cumpleaños',
    path: '/cumple',
    component: Cumpleaños},
// },{
//     name:'cotizar',
//     path:'/cotizar',
//     component: Cotizar
// },{
   { name: 'logear',
    path: '/logear',
    component: Login
}
]


const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
})
export default router  

