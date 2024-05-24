<template>
    <form @submit.prevent="calcularEdad">
        <div class="form-group has-validation">
            <label for="">Ingresa tu fecha de nacimiento</label>
            <input class="form-control" :class="{
                'is-invalid': errorMessages.fecha
            }" v-model="form.fecha" type="date">
            <div v-if="errorMessages.fecha" class="invalid-feedback">
                <span v-for="error in errorMessages.fecha">
                    {{ error }}
                </span>
            </div>
            <h1> {{ saludo }}</h1>
        </div>
        <div class="form-group">
            <label for="">Ingresa tu nombre</label>
            <input class="form-control" v-model="form.nombre" type="text">

        </div>
        <button class="btn btn-primary" type="submit">Enviar</button>
    </form>
</template>
<script setup>
import { ref } from 'vue';
import dayjs from 'dayjs';

const errorMessages = ref({})
const form = ref({
    fecha: null
})
const saludo = ref ('')

// const calcularEdad =  () => {
//     alert(`Hola ${form.value.nombre} tienes ${dayjs().diff(dayjs(form.value.fecha), 'year')} años`)
// }
const calcularEdad = async () => {
    try {
        const { data } = await axios.post('/cumple', form.value)
        saludo.value=(data.data)
    } catch (error) {
        if (error.response.status == 422) {
            errorMessages.value = error.response.data.errors
        }
    }
}


</script>