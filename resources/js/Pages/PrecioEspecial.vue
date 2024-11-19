<template>
    <v-card>
      <v-card-title>
        <v-row>
          <v-col cols="10"></v-col>
          <v-col cols="2" class="d-flex justify-end">
            <v-icon @click="emit('cerrar')" class="cursor-pointer" icon="mdi-close"></v-icon>
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
          single-line
        ></v-select>
        <v-text>Precio actual: {{ SelectedProduct?.precio_de_venta ? formatCurrency(SelectedProduct.precio_de_venta) : formatCurrency(0) }}</v-text>
        <v-text-field
          v-model="form.precio"
          type="number"
          class="my-2"
          label="Ingrese el nuevo precio"
        ></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-btn block color="blue" variant="outlined" @click="CreateDiscount()">Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { onMounted, ref } from 'vue';
  import formatCurrency from '../composables/FormatCurrency.js';
  
  // Emit event for closing the dialog
  const emit = defineEmits(['cerrar']);
  
  // Define props for the component
  const props = defineProps({
    id: {
      type: Number,
      required: false
    },
    producto: {
      type: Object,
      required: false
    }
  });
  
  // Define reactive properties
  const SelectedProduct = ref(null);
  const Products = ref([]);
  const form = ref({
    producto_id: null,
    cliente_id: props.id,
    precio: null
  });
  
  // Function to fetch products
  const getProducts = async () => {
    try {
      const response = await axios.get('/api/producto');
      Products.value = response.data.data;
    } catch (error) {
      console.error('Error fetching products:', error);
    }
  };
  
  // Function to create or update a discount
  const CreateDiscount = async () => {
    try {
      form.value.producto_id = SelectedProduct.value.id;
      await axios.post('/api/precio-especial', form.value);
      emit('cerrar');
    } catch (error) {
      console.error('Error creating discount:', error);
    }
  };
  
  // Lifecycle hook to initialize component
  onMounted(() => {
    if (props.id) {
      getProducts();
    }
    if (props.producto) {
      SelectedProduct.value = props.producto;
      form.value.precio = props.producto.precio; // Set initial price for editing
      console.log('Modo edición activado');
    }
  });
  </script>