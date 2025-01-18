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
                    
                        <!-- <v-infinite-scroll
                        height="100"
                        :items="Records"
                        mode="intersect"
                        @load="loadmore"
                        side="end"
                        >
                        <template v-for="item in Records" :key="item">
                            
                            <v-banner icon="mdi-shopping" class="ma-5">
                                
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

                        </v-infinite-scroll> -->
                        <v-infinite-scroll
                                    height="200"
                                    :items="Records"
                                    mode="intersect"
                                    :onLoad="loadmore"
                                    side="end"
                                >
                                    <template v-for="item in Records" :key="item.id">
                                        <v-banner height="100" icon="mdi-shopping" class="ma-5 pa-4">
                                            
                                            <v-banner-text>
                                                {{ formatRelativeTime(item.updated_at) }}

                                                <strong>{{ formatCurrency(item.total) }}</strong>
                                            </v-banner-text>
                                            <v-banner-actions>
                                                <v-btn>hey</v-btn>
                                            </v-banner-actions>
                                        </v-banner>
                                    </template>

                                    <template v-slot:loading>
                                        <v-row class="justify-center">
                                            <v-col cols="auto">
                                                <v-spinner size="48"></v-spinner>
                                            </v-col>
                                        </v-row>
                                    </template>
                                </v-infinite-scroll>




                   
                    
                </v-card>
            </v-col>
        </v-row>
        <overlay :activo="isLoading"></overlay>
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
import overlay from '../../Components/overlay.vue';

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
const current_page = ref(1); 
const lastPage = ref(null); 
const page = ref(1); 
const isLoading = ref(false);
const next_page_url = ref(null);
const activo = ref(false)



const getRecords = async () => {
    try {
        activo.value = true

        const { data } = await axios.get(`/api/corte-caja`);
        Records.value.push(...data.data.data);
        current_page.value = data.data.current_page;
        next_page_url.value = data.data.next_page_url;
        lastPage.value = data.data.last_page;
        page.value = current_page.value + 1;
        activo.value = false

    } catch (error) {
        ElMessage.error('Error al cargar los registros');
        activo.value = false

    } 
};



const formatHour = (fecha) => {
    return dayjs(fecha).format('h:mm A');
}

const formatRelativeTime = (fecha) => {
    return dayjs(fecha).fromNow();
}


const loadmore = ({ done }) => {
    // if (isLoading.value || !next_page_url.value) {
    //     done('empty'); // No hay más datos que cargar
    //     return;
    // }
    
    isLoading.value = true;

    axios.get(next_page_url.value)
        .then(({ data }) => {
            let new_values = data.data.data;
            console.log(data);
            Records.value.push(...data.data.data); // Agregar más registros
            current_page.value = data.current_page;
            next_page_url.value = data.next_page_url;
            isLoading.value = false;
            done('ok'); 
        })
        .catch(() => {
            done('error'); 
            isLoading.value = false;
        });
};


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
  getRecords();
});

</script>
