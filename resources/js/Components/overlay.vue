<template>
  <v-overlay 
    v-model="localActivo" 
    class="align-center justify-center"
    :style="overlayStyles"
  >

    <slot>
      <v-progress-circular
        color="blue"
        size="64"
        indeterminate
      ></v-progress-circular>
    </slot>
  </v-overlay>
</template>

<script setup>
import { ref, watch } from 'vue';

// Definir propiedades (props)
const props = defineProps({
  activo: {
    type: Boolean,
    required: true, // Es obligatorio pasar esta propiedad
  },
  overlayStyles: {
    type: Object,
    default: () => ({
      // backgroundColor: 'rgba(0, 0, 0, 0.5)', // Estilo de fondo semi-transparente
      backgroundColor: '', // Estilo de fondo semi-transparente
    }),
  },
});

// Emitir eventos (opcional)
const emit = defineEmits(['update:activo']);

// Crear una variable local para manejar la reactividad de `activo`
const localActivo = ref(props.activo);

// Observar los cambios en `props.activo` y sincronizar con `localActivo`
watch(() => props.activo, (nuevoValor) => {
  localActivo.value = nuevoValor;
});

// Emitir cambios hacia el componente padre cuando `localActivo` cambie
watch(localActivo, (nuevoValor) => {
  emit('update:activo', nuevoValor);
});
</script>
