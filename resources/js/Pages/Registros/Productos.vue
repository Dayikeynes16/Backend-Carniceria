<template>
<v-container>
    <v-row>
        <v-col cols="6">
            <v-card>
                <v-card-title>Productos</v-card-title>
                <v-card-subtitle>Productos</v-card-subtitle>
                <v-card-text>
                    <v-text-field v-model="form.nombre" variant="outlined" label="Nombre"></v-text-field>
                    <v-text-field v-model="form.precio_produccion" class="" variant="outlined" label="Precio al costo"></v-text-field>
                    <v-text-field v-model="form.precio_de_venta" variant="outlined"  label="Precio al publico"></v-text-field>
                    <!-- <v-file-input
                        v-model="form.imagen"
                        prepend-icon="mdi-image"
                        variant="outlined"
                        accept="image/*"
                        label="Sube la imagen"
                    ></v-file-input> -->
                    <v-btn block variant="outlined" @click="save()">Guardar</v-btn>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="6">
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
                                                <v-img :src="`/storage/${producto.imagen}`" max-width="100%"></v-img>
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
        </v-col>



    </v-row>
</v-container>    
</template>
<script setup>


import axios from '../../axios';
import { ref, onMounted } from 'vue';
import { supabase } from '../../supabaseClient';
const form = ref({
    nombre: null,
    precio_de_venta: null,
    precio_produccion: null,
    // imagen: null
})
const productos = ref([]);
const dialog = ref(false);
const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("value");


const save = async () => {
    console.log(form.value.nombre)
    const { data } = await supabase.from('Productos')
        .insert({name: form.value.nombre, factory_price: parseFloat(form.value.precio_produccion), sales_price: parseFloat(form.value.precio_de_venta)})
}

const saveProduct = async () => {
    const formData = new FormData();
    formData.append('nombre', form.value.nombre);
    formData.append('precio_produccion', form.value.precio_produccion);
    formData.append('precio_de_venta', form.value.precio_de_venta);
    formData.append('imagen', form.value.imagen);

    await axios.post('/producto', formData, {headers: { "X-CSRF-TOKEN": token,'Content-Type': 'multipart/form-data'}})
    .then(({data}) => {
        console.log(data);
        getProducts();
        form.value = {};
    })
}

const getProducts = async () => {
    await axios.get('/producto')
    .then(({data}) => {
       productos.value = data.data
    })

}

onMounted(() => {
    getProducts()
})

</script>