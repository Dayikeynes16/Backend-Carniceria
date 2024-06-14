<template>
    <v-container>
        <v-col cols="6">
            <v-card>
                <v-container>
                    <v-form @submit.prevent="guardarDireccion()">
                        <v-text-field label="Asigna un nobre a esta direccion" v-model="form.nombre" :error-messages="errorMessages.nombre">
                        </v-text-field>
                        <v-text-field label="Nombre de quien recibe" v-model="form.destinatario"
                            :error-messages="errorMessages.destinatario">
                        </v-text-field>
                        <v-text-field label="Ingrese su dirección completa" v-model="form.direccion"
                            :error-messages="errorMessages.direccion">
                        </v-text-field>
                        <v-text-field v-model="form.telefono" label="Número telefónico"
                            :error-messages="errorMessages.telefono">
                        </v-text-field>
                        <v-select v-model="form.estado" label="Selecciona el estado'" :items="estadosDeMexico" :error-messages="errorMessages.estado">
                        </v-select>
                        <v-text-field maxlength="6" label="Ingresa tu codigo postal":error-messages="errorMessages.codigo_postal" v-model="form.codigo_postal">
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
const estadosDeMexico =[
  "Aguascalientes",
  "Baja California",
  "Baja California Sur",
  "Campeche",
  "Chiapas",
  "Chihuahua",
  "Ciudad de México",
  "Coahuila",
  "Colima",
  "Durango",
  "Estado de México",
  "Guanajuato",
  "Guerrero",
  "Hidalgo",
  "Jalisco",
  "Michoacán",
  "Morelos",
  "Nayarit",
  "Nuevo León",
  "Oaxaca",
  "Puebla",
  "Querétaro",
  "Quintana Roo",
  "San Luis Potosí",
  "Sinaloa",
  "Sonora",
  "Tabasco",
  "Tamaulipas",
  "Tlaxcala",
  "Veracruz",
  "Yucatán",
  "Zacatecas"
];

const form = ref({
    nombre: '',
    destinatario: '',
    direccion: '',
    telefono: '',
    referencias: '',
    estado: '',
    codigo_postal: ''
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
