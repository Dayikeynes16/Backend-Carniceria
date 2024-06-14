<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-row>
                    <v-col v-for="imagen in imagenes" cols="4">
                        <v-card>
                            <v-img :src="imagen.url">
                            </v-img>
                            <v-card-item>
                                <v-card-title>{{ imagen.name }}</v-card-title>
                                <v-card-subtitle>
                                    {{ imagen.price }}
                                </v-card-subtitle>

                                <div class="demo-image__preview">
                                    <el-image :src="imagen.urls[0]" :zoom-rate="1.2" :max-scale="7" :z-index="2000"
                                        :min-scale="0.2" :load :preview-src-list="imagen.urls" :initial-index="0"
                                        fit="cover">

                                    </el-image>
                                </div>
                                <v-card-text v-text="imagen.description">

                                </v-card-text>

                            </v-card-item>


                            <v-card-actions>
                                <v-btn  @click="añadirCarrito(imagen.id)"  prepend-icon="mdi-cart">Añadir al carrito</v-btn>
                                
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
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value');

const page = ref(1);
const paginastotales = ref(1);
const productos = ref([]);
const imagenes = ref([])
const img = ref([])

const modelos = async () => {
    const { data } = await axios.get(`/modelos?page=${page.value}`)
    console.log(data)

    imagenes.value = data.data.map(imagen => {
        return {
            ...imagen,
            urls: imagen.imagenes.map(imagen => imagen.url)
        }
    })
    page.value = data.current_page;
    paginastotales.value = data.last_page
    console.log(paginastotales.value)


}

const añadirCarrito = async (id) => {

    try {
        const { data } = await axios.post('/añadirCarrito', { id }, {
        Headers: {
            'X-CSRF-TOKEN': token
        }
    })
    console.log('hola')
    console.log(data)
        
    } catch (error) {
        
    }
   
}

const mensaje = () => {
    alert('hola')
}


watch(() => page.value, async () => {
    await modelos();
});


onMounted(() => { modelos() })

</script>