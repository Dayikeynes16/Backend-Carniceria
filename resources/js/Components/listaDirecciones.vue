<template>
<v-container class="text-center">
    <v-card-text v-if="visible">

<v-expansion-panels variant="popout">
    <v-expansion-panel v-for="direccion in direcciones">

        <v-expansion-panel-title>
            {{ direccion.nombre }}
        </v-expansion-panel-title>
        <v-expansion-panel-text>

            <v-card-text>
                <h8> Direccion: {{ direccion.direccion }} </h8>
                <v-divider>
                </v-divider>
                <h8>Destinatario: {{ direccion.destinatario }}</h8>
                <v-divider></v-divider>
                <h8>Telefono: {{ direccion.telefono }}</h8>
                <v-divider></v-divider>
                <h8>Referencias: {{ direccion.referencias }}</h8>
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="6">
                        <v-icon color="danger" class="text-left" icon="mdi-delete" @click="open(direccion.id)" ></v-icon>

                    </v-col>
                    <v-col class="text-right" cols="6">
                        <v-icon icon="mdi-Pencil"></v-icon>

                    </v-col>
                </v-row>
            </v-card-actions>
        </v-expansion-panel-text>
    </v-expansion-panel>
</v-expansion-panels>
</v-card-text>
<v-text v-if="empty"> Parece ser que no has registrado ninguna dirección aun, <router-link
    :to="'/direcciones'">
    haz click para añadir una </router-link></v-text>


</v-container>
    

</template>

<script setup>

import { ref } from 'vue';
import axios from 'axios'
const direcciones = ref([])
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value')
const visible = ref(false)
const empty = ref(false)
import { ElMessage, ElMessageBox } from 'element-plus'


const getDirecciones = async () => {
    try {
        const { data } = await axios.get("/getDirecciones")

        direcciones.value = data
        if (direcciones.value.length > 0) {
            visible.value = true
        }
    } catch (error) {

    }
}

getDirecciones()

const eliminarDireccion = async (id) => {
    const { data } = await axios.post('/eliminarDireccion', { id }, {
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    direcciones.value = direcciones.value.filter((direccion) => direccion.id !== id)
    if (direcciones.value.length === 0) {
      empty.value = true    } else {
        empty.value = false
      }
}

const open = (id) => {
    ElMessageBox.confirm(
        'proxy will permanently delete the file. Continue?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
        .then(() => {
            ElMessage({
                type: 'success',
                message: 'Delete completed',
            })
            eliminarDireccion(id)
        })
        .catch(() => {
            ElMessage({
                type: 'info',
                message: 'Delete canceled',
            })
        })
}


</script>