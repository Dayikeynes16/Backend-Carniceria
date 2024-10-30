import * as VueRouter from 'vue-router';
import Index from './Pages/Index.vue';
import RegistroVentas from './Pages/Registros/RegistroVentas.vue';
import Main from './layout/Main.vue';
import Gastos from './Pages/Gastos.vue';
import Clientes from './Pages/Clientes.vue';
import prueba from './Pages/prueba.vue';
import Producto from './Pages/Registros/Productos.vue';
import venta from './Pages/venta.vue';
import DetallesCliente from './Pages/DetallesCliente.vue';
const routes = [
    {
        name: 'Index',
        path: '/',
        component: Main,
        children: [
            {
                name: 'RegistroVentas',
                path: '/registro-ventas',
                component: RegistroVentas
            },
            {
                name: 'Gastos',
                path: '/gastos',
                component: Gastos
            },
            {
                name: 'RegistroClientes',
                path: 'registro-clientes',
                component: Clientes
            },
            {
                name: 'producto',
                path: '/productos',
                component: Producto
            },
            {
                name: 'ventas',
                path: '/ventas',
                component: venta
            },
            {
                name: 'prueba',
                path: 'prueba',
                component: prueba
            },
            {
                path: '/cliente/:id',
                name: 'detalle-cliente',
                component: DetallesCliente,
                props: true  // Esto permite pasar el parámetro como prop
              }
        ]
    }      
    
   
]


const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
})
export default router  

