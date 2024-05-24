<template>
    <button class="btn btn-danger mx-4" @click="saludar()">hola</button>
</template>

<script setup>
    const props = defineProps({nombre:String})
const saludar = async()=>{
    const{data}=await axios.get('/fecha')
    console.log(data)
    alert(`Hola ${props.nombre} hoy es ${data.data}`)
}
</script>