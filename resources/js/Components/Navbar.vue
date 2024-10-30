<template>
    

  
    <v-navigation-drawer
      min-width="200"
      rail
      expand-on-hover
      color="grey-lighten-2"
      nav
    >
      <v-list  nav class="pa-3">
        <v-list-item class="ma-2 mr-4" nav title="Gastos" prepend-icon="mdi-cash-refund" rounded="shaped" color="primary" @click="router.push({ name: 'Gastos' })">
        
        </v-list-item>
        <v-list-item class="ma-2" prepend-icon="mdi-account-box-multiple" nav rounded="shaped" color="primary" @click="router.push({ name: 'RegistroClientes' })">
          Clientes
        </v-list-item>
        
        <v-list-item class="ma-2" prepend-icon="mdi-calendar-clock-outline" rounded="shaped" color="primary" @click="router.push({ name: 'RegistroVentas' })">
          Cierre de caja
        </v-list-item>
        
        <v-list-item icon="mdi-eye" prepend-icon="mdi-food-steak" class="ma-2" rounded="shaped" color="primary" @click="router.push({ name: 'producto' })">
          Productos
        </v-list-item>
        <v-list-item class="ma-2" prepend-icon="mdi-invoice-list-outline" rounded="shaped" color="primary" @click="router.push({ name: 'ventas' })">
          Ventas
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  
  const drawer = ref(false);
  const router = useRouter();
  </script>
  