<template>
    <!-- <button class="btn" @click ='router.push({name:"index"})'>boton 3 </button> -->
    <button class="btn btn-secondary" @click="user()"> boton 3</button>
</template>

<script setup>
import {ref} from 'vue'
const nombre = ref(null)

async function user(){
    try{
        const response = await axios.get('/usuarios3');
        console.log(response.data);
    } catch(error){
        console.log('error al traer usuarios');
    }}

// import {useRouter} from 'vue-router' 
// const router = useRouter()

</script>