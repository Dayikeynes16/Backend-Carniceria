<template >
  <v-app-bar >
    <v-app-bar-nav-icon @click.stop="drawer = !drawer">

    </v-app-bar-nav-icon>
    <v-app-bar-title>Applicaciones Creativas</v-app-bar-title>
    <template v-slot:append>
    <v-btn @click="dialog = true" icon="mdi-cart"></v-btn>
    <v-dialog
      v-model="dialog"
      width="auto"
    >
      <v-card
        max-width="400"
        prepend-icon="mdi-cart"
        text="Your application will relaunch automatically after the update is complete."
        title="Elementos en tu carrito"
      >

      <v-card-text v-if="visible">
        <h8 v-for="item in items">
          {{ item.id }}
        </h8>

      </v-card-text>
        <template  v-slot:actions>
          <v-btn
            class="ms-auto"
            text="Ok"
            @click="dialog = false"
          ></v-btn>
        </template>
      </v-card>
    </v-dialog>
  </template>
  </v-app-bar>
  

  

  



  <v-navigation-drawer v-model="drawer" temporary>

    <v-list-item prepend-icon="mdi-account-circle" value="account" @click='router.push({ name: "Cuenta" })'
      :title="user.name">

    </v-list-item>

    <v-divider></v-divider>
    <v-list-item @click='router.push({ name: "catalogo" })' title="Catalogo">
    </v-list-item>

    <v-list-item @click='router.push({ name: "cotizar" })' title="Cotizar">





    </v-list-item>

    <v-list-item @click='router.push({ name: "editarcatalogo" })' title="Editar Catalogo">

    </v-list-item>
    <v-list-item @click="cerrarSesion" title="Cerrar sesión">

    </v-list-item>
    

  </v-navigation-drawer>




</template>



<script setup>




import axios from 'axios';
import { ref, onMounted } from 'vue';
const dialog = ref(false);
import { useRouter } from 'vue-router';
const user = ref({
  name: null,
  correo: null
})
const router = useRouter()
const drawer = ref(null)
const visible = ref(false)
const items = ref([

])


const get_user = async () => {

  try {
    const { data } = await axios.get('/get_user');
    user.value.name = data.name;
    user.value.correo = data.email
    console.log(user.value.name)
  } catch (error) {
    if (error.response.status === 401) {
      router.push({ name: 'logear' })
      return
    }
  }
}

const cerrarSesion = async() =>{

  try {
    const {data} = await axios.post('/cerrarSesion')
    router.push({name:'logear'})
  } catch (error) {
    
  }
  

}
onMounted(() => { get_user() })

const traerCarrito = async()=>{
  try {


    visible.value=false
    const {data} = await axios.get('/traerCarrito')
    items.value.push(data.productos_carritos)
    visible.value=true
  } catch (error) {
    
  }



}

traerCarrito()

</script>
