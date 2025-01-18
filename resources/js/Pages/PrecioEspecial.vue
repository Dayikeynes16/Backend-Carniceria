<template>
    <v-card>
      <v-card-title>
        <v-row>
          <v-col cols="10"></v-col>
          <v-col cols="2" class="d-flex justify-end">
            <v-icon @click="emit('cancelado')" class="cursor-pointer" icon="mdi-close"></v-icon>
          </v-col>
        </v-row>
      </v-card-title>
      <v-card-text>
        <v-select
          label="Escoja el producto"
          :items="Products"
          item-title="nombre"
          item-value="id"
          v-model="SelectedProduct"
          persistent-hint
          return-object
        ></v-select>
        <v-text v-if="props.producto">Precio actual: {{ SelectedProduct?.precio_de_venta ? formatCurrency(SelectedProduct.precio_de_venta) : formatCurrency(0) }}</v-text>
        
        <v-text v-else>Precio actual: {{ SelectedProduct?.precio_de_venta ? formatCurrency(SelectedProduct.precio_de_venta) : formatCurrency(0) }}</v-text>
        <v-text-field
          v-model="form.precio"
          type="number"
          class="my-2"
          label="Ingrese el nuevo precio"
        ></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-btn v-if="UpdateMode" block color="blue" variant="outlined" @click="UpdateDiscount()">Actualizar</v-btn>
        <v-btn v-else block color="blue" variant="outlined" @click="CreateDiscount()">Guardar</v-btn>

      </v-card-actions>
    </v-card>

    <overlay :activo="OverlayValue"></overlay>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { onMounted, ref } from 'vue';
  import formatCurrency from '../composables/FormatCurrency.js';
  import overlay from '../Components/overlay.vue';
import { ElMessage } from 'element-plus'

  
const OverlayValue = ref(false)
const emit = defineEmits(['cerrar','cancelado']);

  
  const props = defineProps({
    id: {
      type: Number,
      required: false
    },
    producto: {
      type: Object,
      required: false
    },
    update: {
      type: Boolean,
      required: false
    }
  });
  
  const SelectedProduct = ref(null);

  const Products = ref([]);
  const form = ref({
    cliente_id: props.id,
    
  });
  
  const UpdateMode = ref(false);

  const deleteDiscount = async () => {
    const {data} = await axios.delete(`/api/precio-especial/${SelectedProduct.value.id}`)
    emit('cerrar')
  }

  
  const getProducts = async () => {
    try {
      OverlayValue.value = true;
      const response = await axios.get('/api/producto');
      OverlayValue.value = false;

      Products.value = response.data.data;
    } catch (error) {
      overlay.value = false;

      console.error('Error fetching products:', error);
    }
  };
  
  
  const CreateDiscount = async () => {
    try {
      form.value.producto_id = SelectedProduct.value.id;
      await axios.post('/api/precio-especial', form.value);
      emit('cerrar');
    } catch (error) {
      console.error('Error creating discount:', error);
    }
  };

  const UpdateDiscount = async () => {
    try {
      const {data} = await axios.put(`/api/precio-especial/${SelectedProduct.value.id}`,form.value)
      ElMessage({
        type: 'success',
        message: 'Descuento Actualizado con exito'
      })
      emit('cerrar');
    } catch {
      ElMessage.error('Algo salio mal')
    }
  }
  
  onMounted(() => {

    if(!props.update){
      getProducts()
    } else {
      UpdateMode.value = true;
    console.log('perrita ', props.producto);
      OverlayValue.value = false;
      SelectedProduct.value = props.producto;
      SelectedProduct.value.nombre = props.producto.producto.nombre
      SelectedProduct.value.precio_de_venta = props.producto.precio



    }
 
  });
  </script>