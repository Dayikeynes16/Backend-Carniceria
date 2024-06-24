<template>
  <v-app>
    <Navbar v-if="loginStore.autenticado" />

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import Navbar from './Components/Navbar.vue';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useLoginStore } from './stores/login';

const router = useRouter();
const loginStore = useLoginStore();

const auth = async () => {
  try {
    const { data } = await axios.get('/auth');
    if (data.code === 200) {
      loginStore.setAutenticado(true);
    }
  } catch (error) {
    console.error('Error al verificar la autenticación:', error);
    loginStore.setAutenticado(false);
    router.push({ name: 'logear' });
  }
};

onMounted(() => {
  if (loginStore.autenticado) {
    auth();
  } else {
    router.push({ name: 'logear' });
  }
});
</script>
