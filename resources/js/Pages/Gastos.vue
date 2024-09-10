<template>
    <v-container class="mt-0 pt-0">
        <v-row>
            <v-col cols="6">
                <v-row>
                    <v-col  cols="12">
                        <v-card style="height: 450px;">
                            <v-card-title>
                                Se ha gastado: {{ formatCurrency(gastoDiarioTotal) }}
                            </v-card-title>
                                <v-card-subtitle>
                                Gastos del dia
                                </v-card-subtitle>
                            <v-card-text style="height: 300px;" class="overflow-y-auto">
                                <v-expansion-panels >
                                    <v-expansion-panel  v-for="gasto in gastosArray">
                                        <v-expansion-panel-title >
                                            <v-row>
                                                <v-col cols="2">
                                                    <v-icon icon="mdi-home-circle">
                                                    </v-icon>
                                                </v-col>
                                                <v-col cols="5">
                                                    {{ gasto.categoria }}
                                                </v-col>
                                                <v-col cols="5">
                                                    {{ formatRelativeTime(gasto.created_at) }}
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-title>
                                        <v-expansion-panel-text>
                                          <v-row>
                                            <v-col cols="6">
                                                Se gastó: 
                                            </v-col>
                                            <v-col cols="6">
                                                <strong>{{ formatCurrency(gasto.total) }}</strong>
                                            </v-col>
                                            <v-col cols="6">Hora: </v-col>
                                            <v-col cols="6"><strong>{{ formatHour(gasto.created_at) }}</strong></v-col>
                                            <v-col cols="6"></v-col>
                                            <v-col cols="6"></v-col>
                                          </v-row>
                                        </v-expansion-panel-text>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                             
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="6">
                <v-row>
                    <v-col  cols="12">
                        <v-card style="height: 450px;">
                            <v-card-title>
                                Registra un nuevo gasto
                            </v-card-title>
                            <v-card-text style="height: 350px;" class="overflow-y-auto">
                                <v-text-field :error-messages="errorMessages.nombre" v-model="gastos.nombre" variant="outlined" label="Nombre">
                                </v-text-field>
                                <v-select :error-messages="errorMessages.categoria" v-model="gastos.categoria" label="Tipo de gasto" variant= 'outlined' :items="['gastos de limpieza', 'gastos personales', 'gastos de comida']">

                                </v-select>
                                <v-textarea :error-messages="errorMessages.descripcion" v-model="gastos.descripcion" variant="outlined" label="Descripción">
                                </v-textarea>
                                
                                <v-text-field  :error-messages="errorMessages.cantidad" v-model="gastos.cantidad" variant="outlined" label="Cantidad" type="number">
                                </v-text-field>
                                <v-radio-group label="¿fue pagado de ...?"  :error-messages="errorMessages.pagado_caja" v-model="gastos.pagado_caja">
                                    <v-radio label="Pagado de las caja" :value="true"></v-radio>
                                    <v-radio  label="Pagado del cambio" :value="false"></v-radio>
                                </v-radio-group>

                            </v-card-text>
                            <v-card-actions>
                                <v-btn block variant="outlined" @click="saveSpends()">Guardar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                    <v-col cols="12"></v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>

</template>
<script setup>
import { ElMessage } from 'element-plus'
import { ref, onMounted } from 'vue'
import { useRouter } from "vue-router";
import axios from "../axios";
import 'dayjs/locale/es'; 
import localeData from 'dayjs/plugin/localeData';
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime';
import formatCurrency from '../composables/FormatCurrency';
dayjs.extend(localeData);
dayjs.extend(relativeTime);
dayjs.locale('es');


const gastos = ref({
    nombre: null,
    descripcion: null,
    cantidad: null,
    categoria: null,
    pagado_caja: null,
    created_at: null,
    updated_at: null
})

const gastoDiarioTotal = ref(0);
const gastosArray = ref([]);
const errorMessages = ref({});

const getSpends = () => {
    axios.get('/gastos-back')
    .then(({data}) => {
        gastoDiarioTotal.value = 0
        gastosArray.value = data.data
        gastosArray.value.forEach(element => {
            gastoDiarioTotal.value += element.total
            
        })

        console.log(gastoDiarioTotal.value);

    })
}

const saveSpends = () => {
    axios.post('/gastos-back', gastos.value)
    .then(({data}) => {
        getSpends()
        ElMessage({
            type: 'success',
            message: 'Gasto registrado con exito'
        })
    })
    .catch((error) => {
        errorMessages.value = error.response.data.errors
        ElMessage.error('Ups, algo salio mal. :c')
    })
}
const formatHour = (fecha) => {
    return dayjs(fecha).format('h:mm A');
}

const formatearFecha = (fecha) => {
  return dayjs(fecha).format('dddd D [de] MMMM [de] YYYY');
}

const formatRelativeTime = (fecha) => {
    return dayjs(fecha).fromNow();
}

onMounted(() => {
    getSpends();

})
</script>