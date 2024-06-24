<template>
    <v-container>
        <v-row>
            <v-col cols="6">
                <v-card elevation="8">
                    <v-card-item>
                        <v-card-title>
                            <v-avatar
                                ><v-icon icon="mdi-account-circle"></v-icon
                            ></v-avatar>
                            Informacion de la cuenta
                        </v-card-title>
                        <v-card-text>
                            Bienvenido {{ user.name }} <br />
                            Correo: {{ user.correo }}
                        </v-card-text>
                    </v-card-item>
                </v-card>
            </v-col>
            <v-col cols="6">
                <v-card elevation="8">
                    <v-card-title v-text="'Tus direcciones:'"> </v-card-title>
                    <v-card-text>
                        <listaDirecciones></listaDirecciones>
                    </v-card-text>
                    <v-card-actions>
                        <!-- <v-btn
                            class="ma-2"
                            color="#4D869C"
                            @click="dialog = true"
                            >añadir<v-icon icon="mdi-Plus-box"></v-icon
                        ></v-btn> -->

                        <v-btn class="ma-2" color="#4D869C"  @click="router.push({name:'Direcciones'})">añadir<v-icon icon="mdi-Plus-box"></v-icon></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="dialog" class="text-center">
        <Direcciones></Direcciones>
    </v-dialog>
    </v-container>

 
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import Direcciones from "../Components/Direcciones.vue";
import listaDirecciones from "../Components/listaDirecciones.vue";
import router from "../router";
const dialog = ref(false)
const user = ref({
    name: null,
    correo: null,
});

const get_user = async () => {
    const { data } = await axios.get("/get_user");
    user.value.name = data.name;
    user.value.correo = data.email;

    console.log(data.direcciones);
};

get_user();
</script>
