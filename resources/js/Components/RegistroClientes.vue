<template>
    <v-container>
      <v-row>
        <v-col>
          <v-card>
            <v-card-title>
              {{ cliente.update ? 'Editar Cliente' : 'Nuevo Cliente' }}
            </v-card-title>
            <v-card-text>
              <v-text-field v-model="cliente.nombre" variant="outlined" label="Nombre"></v-text-field>
              <v-text-field v-model="cliente.direccion" variant="outlined" label="Dirección"></v-text-field>
              <v-text-field v-model="cliente.telefono" variant="outlined" label="Teléfono"></v-text-field>
              <v-radio-group label="¿El cliente tendrá crédito?" v-model="cliente.credito">
                <v-radio :value="true" label="Asignar Crédito"></v-radio>
                <v-radio :value="false" label="No dar Crédito"></v-radio>
              </v-radio-group>
              <v-text-field type="number" :disabled="!cliente.credito" v-model="cliente.monto" variant="outlined" label="Crédito máximo"></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-row>
                <v-col cols="6">
                  <v-btn block variant="outlined" @click="$emit('cancelado')" color="danger">Cerrar</v-btn>
                </v-col>
                <v-col cols="6">
                  <v-btn block variant="outlined" color="success" @click="saveClient">{{ cliente.update ? 'Actualizar' : 'Guardar' }}</v-btn>
                </v-col>
              </v-row>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>

      

    </v-container>
  </template>
  
  <script setup>
  import { defineEmits, ref, defineProps, onMounted } from 'vue';
  import axios from '@/axios';
  const emit = defineEmits(['cancelado', 'agregado', 'actualizado']);
  const props = defineProps({
    cliente: {
      type: Object,
      required: true,
      default: () => ({
        nombre: '',
        telefono: '',
        direccion: '',
        credito: false,
        monto: 0,
        update: false,
        is_proveedor: false
      })
    }
  });
  
  const cliente = ref({ ...props.cliente });
  
  const saveClient = async () => {
    if (cliente.value.update) {
      cliente.value.monto = parseFloat(cliente.value.monto)
      console.log(cliente.value);
      await axios.put(`/api/client-back/${cliente.value.id}`, cliente.value)
        .then(() => {
          emit('actualizado');
        });
    } else {
        cliente.value.is_proveedor = 0
       await axios.post('/api/client-back', cliente.value)
        .then(() => {
          emit('agregado');
        });
    }
  };
  
  onMounted(() => {
    if (props.cliente.update) {
      cliente.value = { ...props.cliente, update: true };
    } 
    else{
        cliente.value = { ...null, update:false};
    }

  });
  </script>