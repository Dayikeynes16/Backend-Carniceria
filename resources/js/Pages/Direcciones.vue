<template>
<v-container>

    <v-form @submit.prevent="guardarDireccion()">
        <v-text-field label="Nombre de quien recibe" v-model="form.destinatario">

        </v-text-field>

        <v-text-field label="ingrese su direccion completa" v-model="form.direccion">

        </v-text-field>

        <v-text-field v-model="form.telefono" label="Numero telefonico">

        </v-text-field>

        <v-text-field v-model="form.referencias" label="Añada referencias del lugar">

        </v-text-field>

        <v-btn type="submmit" >Guardar</v-btn>

    </v-form>
</v-container>
</template>

<script setup>
import {ref} from 'vue';
import axios from 'axios';
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value')


const form = ref({
    destinatario: null,
    direccion: null,
    telefono: null,
    referencias: null
})

const guardarDireccion = async () =>{
    try {
        const {data} = axios.post('/guardarDireccion', form.value,{headers:{
            'X-CSRF-TOKEN': token}
        })
        console.log(data)
        
    } catch (error) {
        
    }
   
}




</script>