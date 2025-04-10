<template>
  <v-navigation-drawer
    expand-on-hover
    rail
    app
    clipped
    min-width="200"
    color="#08070A"
  >
    <v-list density="compact" nav>
      <v-list-item
        @click="router.push({ name: 'Gastos' })"
        class="nav-item"
        :class="{ 'nav-item--active': isActive('Gastos') }"
      >
        <template #prepend>
          <v-icon class="icon-white">mdi-cash-refund</v-icon>
        </template>
        Gastos
      </v-list-item>

      <v-list-item
        @click="router.push({ name: 'RegistroClientes' })"
        class="nav-item"
        :class="{ 'nav-item--active': isActive('RegistroClientes') }"
      >
        <template #prepend>
          <v-icon class="icon-white">mdi-account-box-multiple</v-icon>
        </template>
        Clientes
      </v-list-item>

      <v-list-item
        @click="router.push({ name: 'RegistroVentas' })"
        class="nav-item"
        :class="{ 'nav-item--active': isActive('RegistroVentas') }"
      >
        <template #prepend>
          <v-icon class="icon-white">mdi-calendar-clock-outline</v-icon>
        </template>
        Cierre de caja
      </v-list-item>

      <v-list-item
        @click="router.push({ name: 'producto' })"
        class="nav-item"
        :class="{ 'nav-item--active': isActive('producto') }"
      >
        <template #prepend>
          <v-icon class="icon-white">mdi-food-steak</v-icon>
        </template>
        Productos
      </v-list-item>

      <v-list-item
        @click="router.push({ name: 'ventasDiarias' })"
        class="nav-item"
        :class="{ 'nav-item--active': isActive('ventasDiarias') }"
      >
        <template #prepend>
          <v-icon class="icon-white">mdi-invoice-list-outline</v-icon>
        </template>
        Ventas diarias
      </v-list-item>

      <v-list-item
        @click="router.push({ name: 'ventas' })"
        class="nav-item"
        :class="{ 'nav-item--active': isActive('ventas') }"
      >
        <template #prepend>
          <v-icon class="icon-white">mdi-invoice-list-outline</v-icon>
        </template>
        Ventas
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const drawer = ref(false);
const router = useRouter();
const route = useRoute();

const isActive = (name) => {
  return route.name === name;
};
</script>

<style scoped>
.nav-item {
  transition: background-color 0.3s, color 0.3s;
  padding-top: 20px;
  padding-bottom: 20px;
  height: 40px;
  display: flex;
  align-items: center;
}
.nav-item:hover {
  background-color: #333;
  color: #fff;
}

.nav-item:hover .v-icon {
  color: #fff;
  opacity: 1 !important;
}

.nav-item--active {
  background-color: #EBE0D5;
  color: #000;
}

.nav-item--active .v-icon {
  color: #267365;
  opacity: 1 !important;
}

.icon-white {
  opacity: 1 !important;
}
</style>