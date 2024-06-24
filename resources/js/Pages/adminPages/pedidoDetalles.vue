<template>
    <v-container>
        <v-card>
        <v-card-title>
            Detalles de la orden n.
        </v-card-title>
        <v-card-text>
            hola hola
        </v-card-text>
    </v-card>

    </v-container>
    
</template>
<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router';
const route = useRoute()
const router = useRouter()

onMounted(async () => {

const { data } = await axios.get(`/carrito/${route.params.id}`)
console.log(data)
})


</script>