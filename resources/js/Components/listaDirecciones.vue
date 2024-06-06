<template>
    <v-card>
        <v-card-title v-text="'Direcciones'">
        </v-card-title>
        <v-card v-for="direccion in direcciones">
            <v-card-title v-text="direccion.direccion ">

            </v-card-title>
            <v-card-actions>
                <v-btn @click="eliminarDireccion(direccion.id)"> <v-icon icon="mdi-delete" ></v-icon></v-btn>
            </v-card-actions>
            

        </v-card>
    </v-card>

</template>

<script setup>

import {ref} from 'vue';
import axios from 'axios'
const direcciones = ref([])
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value')


const getDirecciones = async ()  =>{
    try {
        const {data} = await axios.get("/getDirecciones")
        console.log(data)
        direcciones.value=data
    

    } catch (error) {
        
    }
}
getDirecciones()

const eliminarDireccion = async(id)=>{
    const {data} = await axios.post('/eliminarDireccion',{id},{headers:{
        'X-CSRF-TOKEN': token
    }})
}


</script>