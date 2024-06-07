<template>
    <v-card v-if="visible">
        <v-card v-for="direccion in direcciones">
            <v-card-title v-text="direccion.direccion">
            </v-card-title>
            <v-card-actions>
                <v-btn @click="eliminarDireccion(direccion.id)"> <v-icon icon="mdi-delete"></v-icon></v-btn>
            </v-card-actions>
        </v-card>
    </v-card>
    <v-text v-if="visible !==true" > Parece ser que no has registrado ninguna dirección aun, <router-link :to="'/direcciones'">
            haz click para añadir una </router-link></v-text>


</template>

<script setup>

import { ref } from 'vue';
import axios from 'axios'
const direcciones = ref([])
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value')
const visible = ref(false)


const getDirecciones = async () => {
    try {
        const { data } = await axios.get("/getDirecciones")
      
        direcciones.value = data
        if (direcciones.value.length > 0) {
            visible.value=true
        }
    } catch (error) {

    }
}

getDirecciones()

const eliminarDireccion = async (id) => {
    const { data } = await axios.post('/eliminarDireccion', { id }, {
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    direcciones.value = direcciones.value.filter((direccion) => direccion.id !== id)
    if (direcciones.value.length === 0){
        visible.value = false
    }
}


</script>