<template>
    <v-container class="text-center">
        <v-card-text v-if="addButtonIsVisible">
            <v-expansion-panels variant="popout">
                <v-expansion-panel v-for="direccion in direcciones">
                    <v-expansion-panel-title>
                        {{ direccion.nombre }}
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                        <v-card-text>
                            <h8> Direccion: {{ direccion.direccion }} </h8>
                            <v-divider> </v-divider>
                            <h8>Destinatario: {{ direccion.destinatario }}</h8>
                            <v-divider></v-divider>
                            <h8>Telefono: {{ direccion.telefono }}</h8>
                            <v-divider></v-divider>
                            <h8>Referencias: {{ direccion.referencias }}</h8>
                        </v-card-text>
                        <v-card-actions>
                            <v-row>
                                <v-col class="text-left" cols="6">
                                    <v-icon
                                        color="danger"
                                        icon="mdi-delete"
                                        @click="open(direccion.id)"
                                    ></v-icon>
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
        <v-card-actions v-if="addButtonIsVisible">
                        <v-btn
                            class="ma-2"
                            color="#4D869C"
                            @click="dialog = true"
                            >añadir<v-icon icon="mdi-Plus-box"></v-icon
                        ></v-btn>

                        <!-- <v-btn class="ma-2" color="#4D869C"  @click="router.push({name:'Direcciones'})">añadir<v-icon icon="mdi-Plus-box"></v-icon></v-btn> -->
                    </v-card-actions>

        <p v-else>
            Parece ser que no has registrado ninguna dirección aun,
                <a href="javascript:void(0)" @click="openDialog">haz click para añadir una</a>
        </p>

        <v-dialog v-model="dialog" class="text-center">
        <Direcciones @añadido="getDirecciones"></Direcciones>
    </v-dialog>
    </v-container>
</template>

<script setup>
import Direcciones from "../Components/Direcciones.vue";
import { ref } from "vue";
import axios from "axios";
const direcciones = ref([]);
const dialog = ref(false)
const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("value");

const addButtonIsVisible = ref(false)

import { ElMessage, ElMessageBox } from "element-plus";



const getDirecciones = async () => {
    dialog.value = false
    try {
        const { data } = await axios.get("/getDirecciones");

        direcciones.value = data;
        addButtonIsVisible.value = direcciones.value.length > 0

    
    } catch (error) {}
};

getDirecciones();

const eliminarDireccion = async (id) => {
    const { data } = await axios.post(
        "/eliminarDireccion",
        { id },
        {
            headers: {
                "X-CSRF-TOKEN": token,
            },
        }
    );
    direcciones.value = direcciones.value.filter(
        (direccion) => direccion.id !== id
    );
    if (direcciones.value.length === 0) {
        empty.value = true;
    } else {
        empty.value = false;
    }
};

const open = (id) => {
    ElMessageBox.confirm(
        "proxy will permanently delete the file. Continue?",
        "Warning",
        {
            confirmButtonText: "OK",
            cancelButtonText: "Cancel",
            type: "warning",
        }
    )
        .then(() => {
            ElMessage({
                type: "success",
                message: "Delete completed",
            });
            eliminarDireccion(id);
        })
        .catch(() => {
            ElMessage({
                type: "info",
                message: "Delete canceled",
            });
        });


};

const openDialog = () => {
    dialog.value = true;
};
</script>
