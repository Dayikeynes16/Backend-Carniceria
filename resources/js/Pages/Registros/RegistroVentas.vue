<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <v-card>
                    <v-card-title
                        >Datos de las ventas {{ formatearFecha(dayjs()) }}</v-card-title
                    >
                    <v-card-text> 
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="form.subtotal_efectivo"
                                    variant="outlined"
                                    type="number"
                                    label="total recaudado en efectivo"
                                >
                                </v-text-field
                                ><v-text-field
                                    v-model="form.subtotal_transferencia"
                                    variant="outlined"
                                    type="number"
                                    label="total recaudado por transferencias"
                                >
                                </v-text-field
                                ><v-text-field
                                    v-model="form.subtotal_tarjeta"
                                    variant="outlined"
                                    label="total recaudado por tarjeta"
                                    type="number"
                                >
                                </v-text-field>
                                <h5>Total de ventas del dia: {{ FormatCurrency(parseInt(form.subtotal_efectivo) + parseInt(form.subtotal_tarjeta) + parseInt(form.subtotal_transferencia)) }}</h5>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn block variant="outlined" @click="saveRecord()">Guardar</v-btn>

                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="8">
                <v-card>
                    <v-card-title>
                        Registro de ventas
                    </v-card-title>
                    <
                        <v-virtual-scroll
                        height="200"
                        :items="Records"
                        @load="getRecords"
                        side="end"
                        >
                        <template v-slot:default="{ item }">
                            
                            <v-banner icon="mdi-shopping">
                                
                                <v-banner-text>
                                
                                           {{ formatRelativeTime(item.updated_at) }}

                                           
                                     <br>
                                           <strong>
                                               {{ formatCurrency(item.total) }}
                                           </strong>
                                  
                                   
                                </v-banner-text>
                                <v-banner-actions>
                                    <v-btn>hey</v-btn>
                                </v-banner-actions>
                            </v-banner>
                        </template>

                        </v-virtual-scroll>

                   
                    
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
import { ElMessage } from 'element-plus'
import axios from "../../axios";
import dayjs from "dayjs";
import { ref, onMounted } from "vue";
import FormatCurrency from '../../composables/FormatCurrency'
import 'dayjs/locale/es'; 
import localeData from 'dayjs/plugin/localeData';
import relativeTime from 'dayjs/plugin/relativeTime';
import formatCurrency from '../../composables/FormatCurrency';

dayjs.extend(localeData);
dayjs.extend(relativeTime);
dayjs.locale('es');
const form = ref({
    subtotal_efectivo: 0,
    subtotal_tarjeta: 0,
    subtotal_transferencia: 0,
    total: 0,
    subtotal_pagos_carne: 0,
    subtotal_gastos: 0,
});



const Records = ref([]);
const current_page = ref(1); // Página actual
const lastPage = ref(null); // Última página (se obtiene del servidor)
const page = ref(1); // Contador local de páginas
const isLoading = ref(false);

const getRecords = async ({ done }) => {
    // Evitar solicitudes si ya se llegó a la última página
    // if ( current_page.value === page.value) {
    //     done?.("ok"); // Notifica que no hay más registros por cargar
    //     console.log('perriyabsb');
    //     return;
    // }

    isLoading.value = true;
    if (done?.("loading")) {
        
    }
    try {
        isLoading.value = true;
        const { data } = await axios.get(`/api/corte-caja?page=${page.value}`);

        // Concatenar nuevos registros
        Records.value = [...Records.value, ...data.data.data];

        // Actualizar la página actual y la última página
        current_page.value = data.data.current_page;
        console.log(current_page.value);
        lastPage.value = data.data.last_page;
        page.value = current_page.value + 1; // Incrementar para la siguiente carga

        done?.("ok"); // Finaliza el ciclo de carga infinita
    } catch (error) {
        console.error("Error al cargar registros:", error);
        done?.("error"); // Notifica un error a `v-virtual-scroll`
    } finally {
        isLoading.value = false;
    }

};

const formatHour = (fecha) => {
    return dayjs(fecha).format('h:mm A');
}

const formatRelativeTime = (fecha) => {
    return dayjs(fecha).fromNow();
}


const saveRecord = () => {
    axios.post('/corte-caja', form.value)
    .then(({data}) => {
        ElMessage({
            type: 'success', message: 'Registro Guardado con exito'
        })
        getRecords()
    })
    .catch((error) => {
        ElMessage.error('ocurrio un problema')
    })

}

const formatearFecha = (fecha) => {
  return dayjs(fecha).format('dddd D [de] MMMM [de] YYYY');
}

onMounted(() => {
  getRecords({ side: "end", done: () => {} });
});

</script>
