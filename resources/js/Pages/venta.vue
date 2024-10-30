<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <v-row v-for="venta in ventas">
                    <v-btn color="black" variant="tonal" class="ma-3 pa-8 pt-3" @click="venta.dialog = true" align="center">
                        venta #{{ venta.id }} <br>
                        balanza {{ venta.balanza }}
                    </v-btn>
                    <v-dialog v-model="venta.dialog">
                        <!-- <v-card>
                            <v-card-text >
                                total: {{ FormatCurrency(venta.total) }}
                                <v-card title="Productos de la venta">
                                    <v-card-text v-for="producto in venta.productos">
                                        <v-row>
                                            <v-col cols="6">
                                                Producto:
                                            </v-col>
                                            <v-col cols="6">
                                                {{ producto.producto.nombre }}
                                            </v-col>
                                            <v-col cols="6">
                                                Total:
                                            </v-col>
                                            <v-col cols="6">
                                                {{ FormatCurrency(producto.total) }}
                                            </v-col>
                                            <v-col cols="6">
                                                Kilos: 
                                            </v-col>
                                            <v-col cols="6">
                                                {{ producto.peso }} Kg
                                            </v-col>
                                            <v-col cols="6">
                                                Precio: 
                                            </v-col>
                                            <v-col cols="6">
                                                {{ FormatCurrency(producto.producto.precio_de_venta) }} 
                                            </v-col>
                                        </v-row>
                                   
                                        

                                    </v-card-text>

                                </v-card>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn variant="outlined" @click="deleteSale(venta.id)" block>Cancelar orden</v-btn>
                            </v-card-actions>
                        </v-card> -->
                    <VentaDetalles :id="venta.id"></VentaDetalles>
                    </v-dialog>
                </v-row>
            </v-col>
            <v-col cols="8"></v-col>
        </v-row>

    </v-container>
       
    
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from '../axios';
import FormatCurrency from '../composables/FormatCurrency';
import { supabase } from '../connection';
import VentaDetalles from '../Components/VentaDetalles.vue';

const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("content");

const ventas = ref([])
const getSales = async () => {
    await axios.get('/venta')
    .then(({data}) => {
        ventas.value = data.data;
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