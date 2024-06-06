<template>
    <v-container>
        <v-row>
            <v-col cols="5">
                <v-card>

                    <v-card-item>
                    
                        <v-card-title>
                            <v-avatar><v-icon icon="mdi-account-circle"></v-icon></v-avatar>
                            Informacion de la cuenta
                        </v-card-title>
                        <v-card-text>
                            Bienvenido {{ user.name }} <br>
                            Correo: {{ user.correo }}
                        </v-card-text>

                    </v-card-item>
                </v-card>
            </v-col>
            <v-col cols="4">

                <v-card v-if="visible">
                    <v-card-title v-text="'Tus direcciones:'">
                    </v-card-title>
                    <v-card-text >
                        Parece ser que no has registrado ninguna dirección aun, <router-link :to="'/direcciones'"> haz click para añadir una </router-link>
                    </v-card-text>

                </v-card>
                <listaDirecciones></listaDirecciones>

                

            </v-col>


        </v-row>

    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
const visible = ref(false)
import listaDirecciones from '../Components/listaDirecciones.vue';

const user = ref({
    name: null,
    correo: null
})

const get_user = async () => {
    const { data } = await axios.get('/get_user');
    user.value.name = data.name;
    user.value.correo = data.email
 

    if (Array.isArray(data.direcciones) && data.direcciones.length === 0) {
   
            visible.value = true
        } else {
         
            // Perform actions for a non-empty array
        }

}

get_user();




</script>