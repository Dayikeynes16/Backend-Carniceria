<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <v-card>
                    <v-card-title>
                        Ingresa los datos del modelo
                    </v-card-title>
                    <v-form @submit.prevent="savemodel()">

                        <v-text-field v-model="form.name" label="Nombre del modelo" required :errorMessages="errorMessages.name">
                        </v-text-field multiple>

                        <v-text-field required v-model="form.description" label="Añade una descripcion"></v-text-field>

                        <v-file-input label="Adjunta las fotos necesarias" v-model="form.image">

                        </v-file-input>
                        <v-text-field v-model="form.price" label="Ingresa el precio">

                        </v-text-field>
                        <v-card-actions>
                            <v-btn type="submit" class="mb-8" color="blue" size="large" variant="tonal" block>
                                guardar
                            </v-btn>
                        </v-card-actions>

                    </v-form>
                </v-card>

            </v-col>



            <v-col cols="8">
                <v-row>
                    <v-col v-for="imagen in imagenes" cols="3">
                        <v-card>
                            <v-card-title>
                                {{ imagen.name }}
                            </v-card-title>
                            <v-card-text>
                                <v-img 
                                :src="imagen.url">

                                </v-img>

                            </v-card-text>
                            <v-card-actions>

                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-pagination v-model="page" :length="paginastotales"></v-pagination>
                    </v-col>
                </v-row>

            </v-col>
      
        </v-row>
    </v-container>
</template>

<script setup>
import axios from 'axios';
import { pa } from 'element-plus/es/locales.mjs';
import { onMounted, ref, watch } from 'vue';
const visible = ref(false)
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value')
const imagenes = ref([])
const img = {}
const page = ref(1);
const paginastotales = ref(1);
const errorMessages = ref({})

const form = ref({
    namme: null,
    description: null,
    image: null,
    price: null
})

const savemodel = async () => {
    try {
        const {data}= await axios.post('/savemodel', form.value, {
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'multipart/form-data'
            }
        })
           
     
    } catch (error) {
        if (error.response.status === 422){
            errorMessages.value = error.response.data.errors
        }
    }
}



const modelos = async () => {
    const { data } = await axios.get(`/modelos?page=${page.value}`)
    imagenes.value = data.data
    page.value = data.current_page;
    paginastotales.value = data.last_page
    console.log(paginastotales.value)
}

watch(() => page.value, async () => {
    await modelos();
});


onMounted(() => { modelos() })


</script>
