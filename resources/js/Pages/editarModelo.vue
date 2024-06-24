<template>
    <v-container>
        <v-row>
            <v-col cols="6">
                <v-col cols="">
                    <v-card>
                        <v-card-title v-text="'Actualizar Producto'">
                        </v-card-title>
                        <v-card-subtitle v-text="'Modifica los campos necesarios'">

                        </v-card-subtitle>
                        <v-card-text>
                            <v-text-field v-model="product.name" required :error-messages="errorMessages.name">
                            </v-text-field>
                            <v-text-field v-model="product.description" required
                                :error-messages="errorMessages.description">
                            </v-text-field>
                            <v-text-field v-model="product.price" required :error-messages="errorMessages.price">
                            </v-text-field>
                            <v-btn @click="update()" v-text="'Guardar'">
                            </v-btn>
                        </v-card-text>
                    </v-card>

                </v-col>
                <v-col cols="">
                    <v-card>
                        <v-card-title v-text="'Agregar imagenes'"></v-card-title>
                        <v-card-subtitle></v-card-subtitle>
                        <v-card-text>
                            <el-upload class="upload-demo" drag :http-request="guardarImagen" ref='loadform'
                                accept=".jpeg,.jpg,.png,.gif" :headers="{
                                    'X-CSRF-TOKEN': token
                                }" :auto-upload="true">
                                <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                                <div class="el-upload__text">
                                    Arrastra tu archivo o <em>haz click para subir</em>
                                </div>
                                <template #tip>
                                    <div class="el-upload__tip">
                                        Archivos de imagen de menos de 30 MB
                                    </div>
                                </template>
                            </el-upload>
                        </v-card-text>
                    </v-card>

                </v-col>
            </v-col>



            <v-col cols="6">
                <v-row>
                    <v-col cols="4" v-for="imagen in Imagenes">

                        <v-card>
                            <v-img :src="imagen.url">
                            </v-img>
                            <v-card-actions>
                                <el-button type="danger" :icon="Delete" circle @click="eliminarImagen(imagen.id)" />
                            </v-card-actions>
                        </v-card>


                    </v-col>

                </v-row>



            </v-col>



        </v-row>



    </v-container>








</template>

<script setup>
import { routerKey, useRoute, useRouter } from 'vue-router';
import { onMounted, ref } from 'vue'
import axios from 'axios'
const product = ref({})
const errorMessages = ref({});
const route = useRoute()
const Imagenes = ref([])
const visible = ref(false)
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value');
const router = useRouter()
import { Delete } from '@element-plus/icons-vue'
const id = ref()

onMounted(async () => {

    const { data } = await axios.get(`/productos/${route.params.id}`)
    product.value = data.data
    traerImagenes(product.value.id)
    id.value = product.value.id
})

const update = async () => {
    try {
        await axios.post(`/productos/${route.params.id}`, product.value)
        router.push({name:'editarcatalogo'})

    } catch (error) {
        if (error.response && error.response.status === 422) { errorMessages.value = error.response.data.errors; }
    }
}

console.log(product.value.name)

const traerImagenes = async (id) => {
    visible.value = false
    const { data } = await axios.get('/getImagenes', { params: { id: id } })
    console.log(data)
    Imagenes.value = data
    visible.value = true
}

const eliminarImagen = async (id) => {
    try {
        await axios.post('/eliminarImagen', { id }, {
            headers: {
                'X-CSRF-TOKEN': token
            }
        })
        Imagenes.value = Imagenes.value.filter(imagen => imagen.id !== id)
    } catch (error) {
        alert('error al eliminar el archivo')
    }
}

const guardarImagen = async (file) => {
    const formData = new FormData();
    formData.append('image', file.file);
    formData.append('producto_id', id.value);

    console.log('Producto ID:', id.value);

    try {
        const { data } = await axios.post('/guardarImagen', formData, {
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'multipart/form-data'
            }
        });
        Imagenes.value.push(data.data);
    } catch (error) {
        console.error(error);
    }
};







</script>