<template>
    <v-container>
        <v-row>
            <v-col cols="6">
                <v-card>
                    <v-card-title
                        >Datos de las ventas
                        {{ formatearFecha(dayjs()) }}</v-card-title
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
            <v-col cols="6">
                <v-card>
                    <v-card-title>
                        Registro de ventas
                    </v-card-title>
                    <v-card-text>
                        <v-list v-for="record in Records"> 
                            <v-list-item >
                                <v-list-item-title>
                                    {{ FormatCurrency(record.total) }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ formatearFecha(record.created_at) }}

                                </v-list-item-subtitle>

                            </v-list-item>
                        </v-list>
                    </v-card-text>
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

dayjs.extend(localeData);
dayjs.locale('es');
const form = ref({
    subtotal_efectivo: 0,
    subtotal_tarjeta: 0,
    subtotal_transferencia: 0,
    total: 0,
    subtotal_pagos_carne: 0,
    subtotal_gastos: 0,
});

const currentDate = ref(dayjs().format("DD/MM"));
const Records = ref([]);

const getRecords = () => {
    axios.get("/corte-caja")
    .then(({data}) => {
        Records.value = data.data
    })
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
})

</script>
