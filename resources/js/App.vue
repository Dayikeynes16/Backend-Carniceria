<template>
    <v-app>
      <Navbar>
        
      </Navbar>
       
        <v-main>
            <router-view>
        
            </router-view>
        </v-main>
    </v-app>
</template>

<script setup>
import Navbar from './Components/Navbar.vue';

</script>