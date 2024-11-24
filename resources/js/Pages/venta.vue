<template>
    <v-container>
        <v-row>
            <v-col cols="">
                <v-row v-for="venta in ventas">
                    <v-col cols="4">
                        <v-card>
                            <v-btn color="black"  block class="pt-3" @click="venta.dialog = true" align="center">
                                venta #{{ venta.id }} <br>
                                balanza {{ venta.balanza }}
                            </v-btn>
                        </v-card>
                    </v-col>
                    <v-col cols="8">
                        <v-dialog v-model="venta.dialog" max-width="900" class="ma-0 pt-0">
                                    
                                <VentaDetalles   @cerrar="venta.dialog = false"  :id="venta.id"></VentaDetalles>
                        </v-dialog>
                    </v-col>
               
                </v-row>
            </v-col>
            
       
        </v-row>
        <overlay v-if="OverlayValue"> </overlay>

    </v-container>
       
    
</template>
<script setup>
import { ref, onMounted } from 'vue';
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


const getSales = async () => {
    OverlayValue.value = true
    await axios.get('/venta')
    .then(({data}) => {
        ventas.value = data.data;
    OverlayValue.value = false

    })
}

const deleteSale = async (ventum) => {
  
    axios.delete(`/venta/${ventum}`)
    .then(({data}) => {
        getSales()
    })
}

const handleInserts = (payload) => {
  console.log('Change received!', payload)
  console.log(payload.new);
  ventas.value.push(payload.new);
}

// Listen to inserts
supabase
  .channel('ventas')
  .on('postgres_changes', { event: 'INSERT', schema: 'public', table: 'ventas' }, handleInserts)
  .subscribe()

onMounted(() => {
  getSales()  
})
</script>