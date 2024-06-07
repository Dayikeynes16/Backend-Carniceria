<template>
    <v-container>
        <v-col cols="6">
            <v-card>
                <v-container>
                    <v-form @submit.prevent="guardarDireccion()">
                        <v-text-field label="Nombre de quien recibe" v-model="form.destinatario"
                            :error-messages="errorMessages.destinatario">
                        </v-text-field>

                        <v-text-field label="Ingrese su dirección completa" v-model="form.direccion"
                            :error-messages="errorMessages.direccion">
                        </v-text-field>

                        <v-text-field v-model="form.telefono" label="Número telefónico"
                            :error-messages="errorMessages.telefono">
                        </v-text-field>

                        <v-text-field v-model="form.referencias" label="Añada referencias del lugar"
                            :error-messages="errorMessages.referencias">
                        </v-text-field>

                        <v-btn type="submit">Guardar</v-btn>
                    </v-form>
                </v-container>
            </v-card>
        </v-col>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value');
const errorMessages = ref({});

const form = ref({
    destinatario: '',
    direccion: '',
    telefono: '',
    referencias: ''
});

const guardarDireccion = async () => {
    try {
        const { data } = await axios.post('/guardarDireccion', form.value, {
            headers: {
                'X-CSRF-TOKEN': token
            }
        });


        if (data) {
            router.push({ name: 'Cuenta' });
        }

    } catch (error) {
        if (error.response && error.response.status === 422) {
            errorMessages.value = error.response.data.errors;
        }
    }
};
</script>
