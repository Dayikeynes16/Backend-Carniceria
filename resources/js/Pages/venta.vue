<template>
    <v-container>
        <v-row>
            <v-col cols="8">
                <v-row v-for="venta in ventas">
                    <v-col cols="4">
                        <v-card>
                            <v-btn color="black" :height="100"   block class="pa-5 ma-0" @click="venta.dialog = true" align="center">
                                venta #{{ venta.id }} <br>
                                balanza {{ venta.balanza }}
                            </v-btn>
                        </v-card>
                    </v-col>
                    <v-col cols="8">
                        <v-dialog v-model="venta.dialog" max-width="600" class="ma-0 pt-0">
                                <VentaDetalles  @deleted="getSales()" @cerrar="venta.dialog = false"  :id="venta.id"></VentaDetalles>
                        </v-dialog>
                        <v-row>
                          
                        </v-row>
                    </v-col>

                </v-row>
            </v-col>
            <v-col cols="4">
                <v-row>
                    <v-col cols="7">
                        <v-btn @click="getSales()">Ventas Activas</v-btn>
                    </v-col>
                    <v-col cols="7">
                        <v-btn @click="getPendientes()">Ventas Pendientes</v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <overlay :activo="OverlayValue"> </overlay>

    </v-container>


</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import axios from '../axios';
import FormatCurrency from '../composables/FormatCurrency';
import { supabase } from '../connection';
import VentaDetalles from '../Components/VentaDetalles.vue';
import overlay from '../Components/overlay.vue';


const OverlayValue = ref(false)
const selectedSale = ref()
const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("content");

const ventas = ref([])

const getPendientes = async () => {
    OverlayValue.value = true

    const {data} = await axios.get('/api/sapo/pendiente');
    OverlayValue.value = false;
    ventas.value = data.data;

}

const getSales = async () => {
    OverlayValue.value = true

    const {data} = await axios.get('/venta');
    OverlayValue.value = false;
    ventas.value = data.data;
    console.log(data);

}

// const getNewSales = async () => {

// await axios.get('/api/venta')
// .then(({data}) => {
//     const newsales = data.data;
//     newsales.forEach(venta => {
//         const exists = ventas.value.some((v) => v.id === venta.id);
//             if (!exists) {
//                 ventas.value.push(venta); // Añade el elemento nuevo al array
//             }
//     });
// })
// }




// supabase
//   .channel('ventas')
//   .on('postgres_changes', { event: 'INSERT', schema: 'public', table: 'ventas' }, handleInserts)
//   .subscribe()

onMounted(() => {

  getSales()
  console.log('este es el puto token: ', token);
  

})




</script>