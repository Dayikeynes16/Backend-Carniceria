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

                        <v-text-field required v-model="form.description" label="Añade una descripcion" :errorMessages="errorMessages.description"></v-text-field>

                        <v-file-input label="Adjunta las fotos necesarias" v-model="form.image" :errorMessages="errorMessages.file">

                        </v-file-input>
                        <v-text-field v-model="form.price" label="Ingresa el precio" :errorMessages="errorMessages.price">

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
                    <v-col v-for="imagen in imagenes" cols="4">
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
                                <v-btn  v-text="'Eliminar'" @click="eliminarProducto(imagen.id)">
                                </v-btn>
                                <v-btn v-text="'Editar'" @click="router.push({name:'editarModelo',params:{
                                    id:imagen.id
                                }})">

                                </v-btn>
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
import { useRouter } from 'vue-router';
const visible = ref(false)
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value')
const imagenes = ref([])
const img = {}
const page = ref(1);
const paginastotales = ref(1);
const errorMessages = ref({})

const router = useRouter()

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

        if (data.code === 200){
            modelos();
        }
       
           
     
    } catch (error) {
        if (error.response.status === 422){
            errorMessages.value = error.response.data.errors
        }
    }
}

const eliminarProducto = async (id) =>{
    const {data} = await axios.post('/eliminarProducto',{id});
    if(data.data ===200){
        modelos()
    }
}


const modelos = async () => {
    const { data } = await axios.get(`/modelos?page=${page.value}`)
  
    imagenes.value = data.data

    
    page.value = data.current_page;
    paginastotales.value = data.last_page
    console.log(imagenes)

}

watch(() => page.value, async () => {
    await modelos();
});


onMounted(() => { modelos() })


</script>
