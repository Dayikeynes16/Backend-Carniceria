<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <v-card>
                    <v-card-title>
                        Ingresa los datos del modelo
                    </v-card-title>
                    <v-form @submit.prevent="savemodel()">

                        <v-text-field v-model="form.name" label="Nombre del modelo" required>
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
            <!-- <v-col v-if="visible" cols="4">
                <v-card>
                    <v-card-title>

                    </v-card-title>
                    <v-card-text>

                    </v-card-text>
                    <v-card-actions>

                    </v-card-actions>
                </v-card>

            </v-col> -->


            <v-col cols="3">
                <v-container v-for="imagen in imagenes">
                    <v-card>
                        <v-card-title>
                            {{ imagen.name }}
                        </v-card-title>
                        <v-card-text>
                            <v-img :src="`/${imagen.image}`">

                            </v-img>

                        </v-card-text>
                        <v-card-actions>

                        </v-card-actions>
                    </v-card>
                </v-container>

            </v-col>
            <v-pagination v-if="visible" v-model="page" :length="paginastotales" @input="modelos" rounded="circle"
                next-icon="mdi-menu-right" prev-icon="mdi-menu-left">
            </v-pagination>
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
const paginastotales = ref(0);

const form = ref({
    namme: null,
    description: null,
    image: null,
    price: null
})

const savemodel = async () => {
    try {
        axios.post('/savemodel', form.value, {
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'multipart/form-data'
            }
        })
            .then((response) => {
                alert('guradado exitoso')
                console.log(response.data)
            })
    } catch (error) {

    }
}



const modelos = async () => {
    const { data } = await axios.get(`/modelos?page=${page.value}`)
    imagenes.value = data.data
    page.value = data.current_page;
    console.log(page.value)
    console.log(page)

    const paginacion = data.links.slice(1, data.links.length - 1)

    paginastotales.value = paginacion.length

    visible.value = true
}

watch(page, () => {
    modelos();
});


onMounted(() => { modelos() })


</script>
