<template>
    <v-card>
        <v-card-title>
            {{ item.name }}
        </v-card-title>
        <v-card-text>

            <v-carousel show-arrows="hover" cycle>

                <v-carousel-item v-for="img in item.imagenes" cover :src="img.url">


                </v-carousel-item>

            </v-carousel>


        </v-card-text>
        <v-card-actions>
            <v-btn v-text="'Eliminar'" @click="open(item.id)">
            </v-btn>
            <v-btn v-text="'Editar'" @click="router.push({
                name: 'editarModelo', params: {
                    id: item.id
                }
            })">

            </v-btn>
        </v-card-actions>
    </v-card>

</template>
<script setup>

import { ElMessage, ElMessageBox } from 'element-plus'
const props = defineProps({item:Object})
import router from '../router';
import { useRouter } from 'vue-router';

const emit = defineEmits([
    'eliminado'
])

const eliminarProducto = async (id) => {
    const { data } = await axios.post('/eliminarProducto', { id });

}

const open = async(id) => {

  try {
    const confirmed =   await ElMessageBox.confirm(
        'Borraras permanentemente este producto, ¿Deseas continuar?',
        'Advertencia',
        {
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            type: 'warning',
        }
    )
    await eliminarProducto(id)
    emit('eliminado')
  } catch (error) {
    
  }

}



</script>