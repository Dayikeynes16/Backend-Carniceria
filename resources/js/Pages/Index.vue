<template>
    <h1>Miau</h1>
    <button-component :nombre="nombre"></button-component>
   
    <MiBotonComponent ></MiBotonComponent>
    <input type="text" v-model="nombre">
</template>

<script setup>

import ButtonComponent from '../Components/Button.vue';
import MiBotonComponent from '../Components/MiBoton.vue';

</script>