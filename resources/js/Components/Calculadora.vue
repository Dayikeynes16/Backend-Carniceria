<template>
    <v-row class="mx-0 px-0">
      <v-col class="mx-0 px-0" cols="4" v-for="button in buttons" :key="button">
        <v-btn 
          variant="tonal" 
          color="grey-2" 
          class="pa-0 ma-0" 
          @click="appendValue(button)"
        >
          {{ button }}
        </v-btn>
      </v-col>
      <v-col cols="12">
        <v-btn block color="grey-2" @click="clearInput">Limpiar</v-btn>
      </v-col>
    </v-row>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    total: {
      type: Number,
      required: true,
      validator: (value) => value >= 0
    }
  });
  
  const emit = defineEmits(['update:amount', 'update:change']);
  
  const inputValue = ref('');
  const buttons = ['7', '8', '9', '4', '5', '6', '1', '2', '3', '0', '00', '.'];
  
  // Función para agregar valores a la entrada
  const appendValue = (value) => {
    if (value === '.' && inputValue.value.includes('.')) {
      return; // Evita múltiples puntos decimales
    }
    inputValue.value += value;
  
    // Convierte inputValue a número y calcula el cambio
    const amount = parseFloat(inputValue.value) || 0;
    const change = Math.max(0, amount - props.total);
  
    // Emite los valores actualizados
    emit('update:amount', amount);
    emit('update:change', change);
  };
  
  // Función para limpiar la entrada
  const clearInput = () => {
    inputValue.value = '';
    emit('update:amount', 0);
    emit('update:change', 0);
  };
  </script>