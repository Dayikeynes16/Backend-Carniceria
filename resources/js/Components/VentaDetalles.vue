<template>
    <v-card>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn variant="outlined">Cerrar</v-btn>
      </v-card-actions>
      <v-card-text>
        "Productos de la venta"

          <v-card-text v-for="producto in venta.productos" :key="producto.id">
            <v-row>
              <v-col cols="6">
                Producto:
              </v-col>
              <v-col cols="6">
                {{ producto.producto.nombre }}
              </v-col>
              <v-col cols="6">
                Total:
              </v-col>
              <v-col cols="6">
                {{ FormatCurrency(producto.total) }}
              </v-col>
              <v-col cols="6">
                Kilos:
              </v-col>
              <v-col cols="6">
                {{ producto.peso }} Kg
              </v-col>
              <v-col cols="6">
                Precio:
              </v-col>
              <v-col cols="6">
                {{ FormatCurrency(producto.producto.precio_de_venta) }}
              </v-col>
            </v-row>
          </v-card-text>
     
      </v-card-text>
    </v-card>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import FormatCurrency from '../composables/FormatCurrency.js';
  const loading = ref(false);
  // Definimos los props que recibe el componente.
  const props = defineProps({
    id: {
      type: Number,
      required: true
    }
  });
  
  // Variables reactivas para los datos.
  const venta = ref({
    // total: 0,
    // productos: []
  });
  
  // Función para hacer la petición al backend.
  const fetchVenta = async () => {
    try {
        
      const response = await axios.get(`api/venta/${props.id}`);
      venta.value = response.data.data;
    } catch (error) {
      console.error('Error al obtener la venta:', error);
    }
  };
  
  // Ejecutamos la función cuando el componente se monta.
  onMounted(() => {
    fetchVenta();
  });
  </script>