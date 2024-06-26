<template>
    <v-container>
        <v-card>
            <v-card-title>
                Detalles de la orden n.-{{ carrito.id }}
            </v-card-title>
            <v-card-text>
                <v-table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Piezas</th>
                            <th>Tiempo estimado</th>
                            <th>Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in files" :key="i.id">
                            <td>{{ i.nombre }}</td>
                            <td>{{ i.cantidad }}</td>
                            <td>{{ i.minutos }} minutos</td>
                            <td>
                                <v-icon @click="download(i.id, i.nombre)" icon="mdi-download"></v-icon>
                            </td>
                        </tr>
                        <tr v-for="i in productos" :key="i.producto.id">
                            <td>{{ i.producto.name }}</td>
                            <td>{{ i.cantidad }}</td>
                        </tr>
                    </tbody>
                </v-table>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const files = ref([]);
const productos = ref([]);
const carrito = ref({})

onMounted(async () => {
    const { data } = await axios.get(`/carrito/${route.params.id}`);
    files.value = data.files;
    productos.value = data.productos;
    carrito.value = data.carrito
});

const download = async (id, nombre) => {
    try {
        const response = await axios.get(`/DownloadFile/${id}`, {
            responseType: 'blob' 
        });
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `${nombre}.stl`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (error) {
        console.error('Error downloading the file', error);
    }
}
</script>
