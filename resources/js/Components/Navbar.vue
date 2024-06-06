
<template>
  <!-- <v-app-bar :elevation="2">
  <template v-slot:prepend>
    <v-navigation-drawer v-model="drawer" temporary>
      <v-list-item
      title="{{ user.value.name }}"
      >

      </v-list-item>
        
    </v-navigation-drawer>

  </template>
  
</v-app-bar> -->


<v-app-bar>

  

  <v-app-bar-nav-icon
  @click.stop="drawer = !drawer">

</v-app-bar-nav-icon>
  <v-app-bar-title>Applicaciones Creativas</v-app-bar-title>

</v-app-bar>
<v-navigation-drawer v-model="drawer" temporary>

    <v-list-item
  
    prepend-icon="mdi-account-circle"
    value="account"
    @click= 'router.push({name:"Cuenta"})'
    :title="user.name ">
  
    </v-list-item>

    <v-divider></v-divider>
    <v-list-item
    @click= 'router.push({name:"catalogo"})'
    title="Catalogo"
    >
    </v-list-item>

    <v-list-item
    @click= 'router.push({name:"cotizar"})'
    title="Cotizar"
    >
    
    


    </v-list-item>

  </v-navigation-drawer>




</template>

<script setup>



import axios from 'axios';
import {ref} from 'vue';
import { useRouter } from 'vue-router';
const user = ref({
  name: null, 
  correo: null
})
const router = useRouter()
const drawer = ref(null)

const get_user = async () => {

  try {
    const {data} = await axios.get('/get_user');
  user.value.name = data.name;
  user.value.correo = data.email
  console.log(user.value.name)
    
  } catch (error) {
    if(error.response.status===401){
      router.push({name:'logear'})
      return
    }
    
  }
  

}

get_user();

</script>
