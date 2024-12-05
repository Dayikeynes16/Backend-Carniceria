<template>
       <v-card>
                    <v-card-title>Productos</v-card-title>
                    <v-card-text>
                        <v-text-field v-model="Producto.nombre" variant="outlined" label="Nombre"></v-text-field>
                        <v-text-field v-model="Producto.precio_produccion" class="" variant="outlined" label="Precio al costo"></v-text-field>
                        <v-radio-group label="¿El producto puede ser vendido por piezas?" v-model="Producto.piezas">
                <v-radio :value="true" label="Piezas"></v-radio>
                <v-radio :value="false" label="Solo KG"></v-radio>
                        </v-radio-group>
                        <v-radio-group label="¿Es un producto para venta al publico?" v-model="Producto.publico">
                <v-radio :value="true" label="Si"></v-radio>
                <v-radio :value="false" label="No, para uso interno"></v-radio>
                        </v-radio-group>
                        <v-text-field v-model="Producto.precio_de_venta" variant="outlined"  label="Precio al publico"></v-text-field>
                        <v-file-input
                            v-model="Producto.imagen"
                            prepend-icon="mdi-image"
                            variant="outlined"
                            accept="image/*"
                            label="Sube la imagen"
                        ></v-file-input>
                    </v-card-text>
                    <v-card-actions>
                    <v-row>
                        <v-col cols="6">
                            <v-btn @click="emit('cancelado')" block variant="outlined" >Cancelar</v-btn>
                        </v-col>
                     
                        <v-col cols="6" v-if="Producto.update">
                            <v-btn @click="UpdateProduct()" block variant="outlined" color="success" >Guardar</v-btn>
                        </v-col>
                        <v-col cols="6" v-else>
                            <v-btn block variant="outlined"  color="success" @click="saveProduct()">Guardar</v-btn>
                        </v-col>
                    </v-row>
                    </v-card-actions>
                </v-card>
</template>
<script setup>
import axios from '../../axios';
import { ref, onMounted, defineProps, defineEmits } from 'vue';
const emit = defineEmits(['cancelado', 'agregado', 'actualizado']);
const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("content");

const Producto = ref({
    nombre: null,
    precio_de_venta: null,
    precio_produccion: null,
    piezas: null,
    imagen: ''
})

const props = defineProps({
    Producto: {
      type: Object,
      required: true,
      default: () => ({
        id: null,
        nombre: '',
        precio_de_venta: 0,
        precio_produccion: 0,
        imagen: '',
        piezas: false,
        update: false,
      })
    }
  });
const saveProduct = async () => {
    const formData = new FormData();
    formData.append('nombre', Producto.value.nombre);
    formData.append('precio_produccion', Producto.value.precio_produccion);
    formData.append('precio_de_venta', Producto.value.precio_de_venta);
    formData.append('piezas', Producto.value.piezas ? '1' : '0');  
    formData.append('imagen', Producto.value.imagen); 
    formData.append('publico', Producto.value.publico ? 0:1); 
    
    data= await axios.post('/api/producto', formData)
    .then(({data}) => {
        console.log(data);
        emit('agregado')
        getProducts();
        form.value = {};
    })
}

const UpdateProduct = async () => {
    const formData = new FormData();

    if (Producto.value.imagen instanceof File) {
        formData.append('imagen', Producto.value.imagen);
    }

    
    const data = await axios.put(`/api/producto/${Producto.value.id}`, Producto.value, formData)
        .then((data)=>{
            console.log('hehehe'),
            emit('actualizado')
        })
   
};
onMounted(() => {
    if (props.Producto.update) {
      Producto.value = { ...props.Producto, update: true };
    } 
    else{
        Producto.value = { ...null, update:false};
    }
})
</script>