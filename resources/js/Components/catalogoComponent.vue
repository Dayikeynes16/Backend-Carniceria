<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-row >
                    <v-col v-for="imagen in imagenes" cols="4">
                        <v-card>
                            <v-img :src="imagen.url">
                            </v-img>
                            <v-card-item>
                                <v-card-title>{{ imagen.name }}</v-card-title>

                                <v-card-text>
                                    {{ imagen.description }}
                                </v-card-text>
                            </v-card-item>


                            <v-card-actions>
                                <v-btn>Añadir al carrito</v-btn>
                                <v-btn>Comprar ahora
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
import { ref, watch, onMounted } from 'vue';
const page = ref(1);
const paginastotales = ref(1);
const productos = ref([]);
const imagenes = ref([])

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