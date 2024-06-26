<template>
    <v-card>
      <v-card-text>
        <p>¿A dónde se enviará? Elige</p>
        <v-select
          v-model="selectedDireccion"
          :items="mappedDirecciones"
          item-title="nombre"
          item-value="id"
          label="Selecciona una dirección"
        >
        </v-select>
      </v-card-text>
    </v-card>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from "vue";
  import axios from "axios";
  
  const selectedDireccion = ref(null);
  const Direcciones = ref([]);
  
  const getDirecciones = async () => {
    try {
      const { data } = await axios.get("/getDirecciones");
      Direcciones.value = data;
    } catch (error) {
      console.error("Error fetching directions:", error);
    }
  };
  
  onMounted(() => {
    getDirecciones();
  });
  
  const mappedDirecciones = computed(() => {
    return Direcciones.value.map(direccion => ({
      nombre: `${direccion.nombre} - ${direccion.direccion}`,
      id: direccion.id,
    }));
  });
  </script>