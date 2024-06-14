<template>
    <v-app>
      <Navbar v-if="visible" >
        
      </Navbar>
       
        <v-main>
            <router-view>
        
            </router-view>
        </v-main>
    </v-app>
</template>

<script setup>
import Navbar from './Components/Navbar.vue';
import axios from 'axios'
import {ref, onMounted} from 'vue'
const visible = ref(false)

const auth = async () => {
  try {
    const { data } = await axios.get('/auth');
    if (data === 200) {
      visible.value = true;
    }
  } catch (error) {
    console.error('Error al verificar la autenticación:', error);
    visible.value = false;
  }
};

onMounted(() => {
    auth();
});




</script>