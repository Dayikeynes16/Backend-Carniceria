<template>
    <v-container>
        <v-row>
            <v-col cols="6">
                <v-card>
            <v-card-title v-text="'Actualizar Producto'">
            </v-card-title>
            <v-card-text>
                <v-text-field v-model="product.name">
                </v-text-field>
                <v-text-field v-model="product.description">
                </v-text-field>
                <v-text-field v-model="product.price">
                </v-text-field>
                <v-btn @click=" update()" v-text="'Guardar'">
                </v-btn>
            </v-card-text>
        </v-card>

            </v-col>
            

        </v-row>
        
    </v-container>








</template>

<script setup>
import { useRoute } from 'vue-router';
import { onMounted, ref } from 'vue'
import axios from 'axios'
const product = ref({})


const route = useRoute()

onMounted(async () => {
    const { data } = await axios.get(`/productos/${route.params.id}`)
    product.value = data.data
    console.log(product.value)
})

const update = async () => {
    await axios.post(`/productos/${route.params.id}`, product.value)
}




</script>