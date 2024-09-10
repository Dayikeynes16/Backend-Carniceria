<template>
    <v-app-bar color="primary" scroll-behavior="collapse" scroll-threshold="224" >
        <v-app-bar-nav-icon color="white" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        
    </v-app-bar>

    <v-navigation-drawer color="grey-lighten-2" v-model="drawer" temporary>
        <v-list>
            <v-list-item class="ma-2" rounded="shaped" color="primary" @click="router.push({name: 'Gastos'})">Gastos </v-list-item>
            <v-list-item class="ma-2" rounded="shaped" color="primary" @click="router.push({name: 'RegistroClientes'})">Clientes </v-list-item>
            <v-list-item class="ma-2" rounded="shaped" color="primary" @click="router.push({name: 'prueba'})">Probando </v-list-item>
            <v-list-item class="ma-2" rounded="shaped" color="primary" @click="router.push({name: 'RegistroVentas'})">Cierre de caja</v-list-item>
            <v-list-item class="ma-2" rounded="shaped" color="primary" @click="router.push({name: 'producto'})">Productos</v-list-item>
            <v-list-item class="ma-2" rounded="shaped" color="primary" @click="router.push({name: 'ventas'})">Ventas</v-list-item>
        </v-list>
    </v-navigation-drawer>

</template>
<script setup>
import { ref } from 'vue'
import { useRouter } from "vue-router";
const router = useRouter();

const drawer = ref(null);

</script>