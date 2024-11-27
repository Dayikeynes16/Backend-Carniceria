<template>
<v-row>
    <v-col cols="12" class="ml-0">
        <v-card class="ma-4 pa-4" elevation="6">
            <v-card-title>Inventario</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-row>
                            <v-col cols="8">
                                <v-text-field
                                    v-model="search"
                                    label="Buscar"
                                    prepend-inner-icon="mdi-magnify"
                                    variant="outlined"
                                    hide-details
                                    single-line
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-btn  height="100%" block @click="NewClient()">Nuevo</v-btn>
                            </v-col>
                             </v-row>
                        <v-row>
                            <v-col>
                                <v-data-table
                                :headers="headers"
                                :items="productos"
                                :loading="loading"
                                :search="search"
                                >
                                <template v-slot:item.imagen="{item}">
                                    <v-img :src="item.imagen"></v-img>
                                    </template>
                                <template v-slot:item.acciones="{item}">
                                    <v-btn @click="editProduct(item)">Editar</v-btn>
                                </template>
                    
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-col>
    <v-row>
        <v-col cols="6">
            <v-dialog v-model="addNewProduct">
                <!-- <v-card>
                    <v-card-title>Productos</v-card-title>
                    <v-card-subtitle>Productos</v-card-subtitle>
                    <v-card-text>
                        <v-text-field v-model="form.nombre" variant="outlined" label="Nombre"></v-text-field>
                        <v-text-field v-model="form.precio_produccion" class="" variant="outlined" label="Precio al costo"></v-text-field>
                        <v-text-field v-model="form.precio_de_venta" variant="outlined"  label="Precio al publico"></v-text-field>
                        <v-file-input
                            v-model="form.imagen"
                            prepend-icon="mdi-image"
                            variant="outlined"
                            accept="image/*"
                            label="Sube la imagen"
                        ></v-file-input>
                    </v-card-text>
                    <v-card-actions>
                    <v-row>
                        <v-col cols="6">
                            <v-btn block variant="outlined" @click="addNewProduct = false">Cancelar</v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn block variant="outlined" color="success" @click="saveProduct()">Guardar</v-btn>
                        </v-col>
                    </v-row>
                    </v-card-actions>
                </v-card> -->
           <RegistroProductos @actualizado="getProducts()" @agregado="getProducts()" @cancelado="addNewProduct = false" :Producto="selectedClient"></RegistroProductos>
            </v-dialog>
        </v-col>
        <!-- <v-col cols="6">
            <v-card title="Productos existentes" >
                <v-card-text>
                    <v-list v-for="producto in productos">
                        <v-list-item :title="producto.nombre">
                            <v-row>
                                <v-col cols="8">
                                    precio: {{ producto.precio_de_venta }} 
                                </v-col>
                                <v-col cols="4">
                                    <v-btn variant="outlined" block color="success" append-icon="mdi-eye-outline" @click="producto.dialog = true">Información</v-btn>
                                </v-col>
                            </v-row>
                            <v-dialog v-model="producto.dialog" max-width="500px">
                                <v-card :title="producto.nombre">
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="6">
                                                Precio al publico: {{ producto.precio_de_venta }}
                                                Precio al costo: {{ producto.precio_produccion }}
                                            </v-col cols=6>
                                            <v-col>
                                                <v-img :src="producto.imagen"></v-img>
                                            </v-col>
                                        </v-row>
                                        

                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn>Eliminar</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-list-item>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-col> -->
    </v-row>
</v-row>    
</template>
<script setup>
import RegistroProductos from '../../Pages/Registros/RegistroProductos.vue'
import axios from '../../axios';
import { ref, onMounted } from 'vue';
const form = ref({
    nombre: null,
    precio_de_venta: null,
    precio_produccion: null,
})
const selectedClient = ref({
        nombre: '',
        precio_de_venta: 0,
        precio_produccion: 0,
        imagen: '',
        update: false,
});
const search = ref('');
const headers = ref([
{    title: 'Imagen', key: 'imagen' },
    { title: 'Nombre', key: 'nombre' },
    { title: 'Precio Venta:', key: 'precio_de_venta' },
    { title: 'Acciones', key: 'acciones' }
  ]);

const addNewProduct = ref(false)
const productos = ref([]);
const dialog = ref(false);
const loading = ref(false)
const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("value");

const editProduct = (product) => {
    selectedClient.value = { ...product, update: true };
    addNewProduct.value = true;
  };

const NewClient = async () => {
    addNewProduct.value = true
    selectedClient.value = {}

}
const saveProduct = async () => {
    const formData = new FormData();
    formData.append('nombre', form.value.nombre);
    formData.append('precio_produccion', form.value.precio_produccion);
    formData.append('precio_de_venta', form.value.precio_de_venta);
    formData.append('imagen', form.value.imagen);
    
    await axios.post('/producto', formData, {headers: { "X-CSRF-TOKEN": token,'Content-Type': 'multipart/form-data'}})
    addNewProduct.value = false

    .then(({data}) => {
        console.log(data);
        getProducts();
        form.value = {};
    })
}

const getProducts = async () => {
    addNewProduct.value = false
    loading.value = true
    await axios.get('/producto')
    .then(({data}) => {
       productos.value = data.data
       loading.value = false
    })
}

onMounted(() => {
    getProducts()
})

</script>