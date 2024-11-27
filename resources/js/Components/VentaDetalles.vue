<template>
    <v-card>
      <v-overlay :model-value="overlay"
      class="align-center justify-center"
      >
            <v-progress-circular
              color="blue"
              size="64"
              indeterminate
            ></v-progress-circular>
      </v-overlay>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-row>
          <v-col cols="6">
           
           <v-title style="font-size: larger; text-align: center;">Resumen</v-title> 
          </v-col>
          <v-col cols="6" style="text-align: right;" >
            <v-icon icon="mdi-close" variant="tonal" style="text-align: right;"  @click="emit('cerrar')"></v-icon>
          </v-col>
        </v-row>
      </v-card-actions>
      <v-tabs  v-model="tab" fixed-tabs>
        <v-tab :value="1" text="Productos" >
        </v-tab>
        <v-tab :value="2" text="Cliente">
          
        </v-tab>
        <v-tab :value="3" text="Pago">
          
        </v-tab>
        <v-tab :value="4" text="Resumen">

        </v-tab>
        </v-tabs>
        <v-card-text>
        
                <v-tabs-window v-model="tab">
                  <v-tabs-window-item :value="1">
                    <v-table>
                      <thead>
                        <tr>
                          <th>Producto</th>
                          <th>Precio</th>
                          <th v-if="venta.cliente_id">Precio con descuento</th>
                          <th>Cantidad</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="producto in venta.productos" text-align="center">
                          <td>
                            {{ producto.producto.nombre }}
                          </td>
                          <td>
                            {{ FormatCurrency(producto.producto.precio_de_venta) }}
                          </td>
                          <td  v-if="venta.cliente_id" >{{ formatCurrency(producto.total/producto.peso) }}</td>
                          <!-- <td>{{ formatCurrency(producto.peso * producto.producto.precio_de_venta) }}</td> -->
                          <td>
                            {{ producto.peso }} kg
                          </td>  
                          <td>
                            {{ FormatCurrency(producto.total) }}
                          </td>
                        </tr>
                      </tbody>
                    </v-table>
                    <v-row class="pa-4">
                      <v-col cols="8"></v-col>
                      <v-col cols="3" >
                        Total: {{ FormatCurrency(venta.total) }}
                      </v-col>
                    </v-row>
        
                    <!-- <v-card-text v-for="producto in venta.productos" :key="producto.id">
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
                    </v-card-text> -->
                  </v-tabs-window-item>
                  <v-tabs-window-item :value="2">
                  
                    <v-select
                    v-model="selectedClient"
                    :items="clients"
                    item-title="nombre"
                    item-value="id"
                    persistent-hint
                    label="Seleccione el cliente"
                    return-object
                    single-line
                    >

                    </v-select>

                    <v-btn block variant="tonal" color="blue" @click="AsociateSale()">Asociar</v-btn>

                </v-tabs-window-item>
                <v-tabs-window-item :value="3">
                  <v-row>
                  </v-row>
                      <v-row>
                        <v-col cols="12"
                        
                        >
                      <div style="text-align: center; width: 400px;">
                        <strong style="font-size: x-large;">Total: {{ FormatCurrency(venta.total) }}</strong><br>
                        <strong style="font-size: x-large;">Resta: {{ FormatCurrency(pago.resta) }} </strong>
                        <br>
                        <strong style="font-size: x-large;" v-if="pago.cambio > 0">Cambio: {{ FormatCurrency(pago.cambio) }} </strong>
                      
                      </div>
                    </v-col>
                        
                          <v-col cols="12">
                            <v-text-field type="number"
                            v-model="form.efectivo" 
                            variant="outlined"
                            label="Efectivo"
                        width="400"

                            ></v-text-field>
                          </v-col>
                    
                        <v-col cols="12">
                          <v-text-field type="number"
                          v-model="form.tarjeta" 
                          variant="outlined"
                          width="400"
                          label="Tarjeta"
                          ></v-text-field>
                        </v-col>
                      
                        <v-col cols="12">
                          <v-text-field type="number"
                          
                          variant="outlined"
                          width="400"
                          v-model="form.transferencia" 
                          label="Transferencia"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                          <v-btn block>Pendiente</v-btn>
                        </v-col>
                        <v-col cols="6">
                          <v-btn block>cobrar</v-btn>
                        </v-col>

                        
                      
                      </v-row>

                   
                </v-tabs-window-item>
                <v-tabs-window-item :value="4">
                  verga
                </v-tabs-window-item>
        
                </v-tabs-window>

      </v-card-text>
        
    </v-card>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import FormatCurrency from '../composables/FormatCurrency.js';
  import Calculadora from './Calculadora.vue'
import { ElMessage } from 'element-plus'
import formatCurrency from '../composables/FormatCurrency.js';
import { computed } from 'vue';

  const emit = defineEmits(['cerrar','overlay']);
  const selectedClient = ref(null);
  const clients = ref([]);
  const overlay = ref(false);
  const tab = ref(null);
  const loading = ref(false);

  const props = defineProps({
    id: {
      type: Number,
      required: true
    }
  });

  const form = ref({
    tarjeta: 0,
    transferencia: 0,
    efectivo: 0
  });
  
  const venta = ref({
 
  });


  const AsociateSale = async () => {
    overlay.value = true;
    let response = await axios.put(`api/venta/${props.id}`,{cliente_id: selectedClient.value.id})
    .then((response) => { 
      console.log(response.data.data,'dahebbe')

      overlay.value = false
      venta.value = response.data.data;
      console.log(venta.value);
      ElMessage({
            type: 'success',
            message: 'Venta actualizada'
        })
      tab.value = 3
    })


  }
  
  const fetchVenta = async () => {
    try {
      overlay.value = true;
      
      const response = await axios.get(`api/venta/${props.id}`)
      .then((response)=>{
        venta.value = response.data.data;
        clients.value = response.data.clientes;
        })
      overlay.value = false;
      
    } catch (error) {
      console.error('Error al obtener la venta:', error);
      overlay.value = false;

    }
  };

  const pago = computed(() => {
  const total = venta.value.total || 0;
  const efectivo = form.value.efectivo || 0;
  const tarjeta = form.value.tarjeta || 0;
  const transferencia = form.value.transferencia || 0;

  const resta = total - efectivo - tarjeta - transferencia;
  const cambio = resta < 0 ? -resta : 0;

  return {
    total,
    resta: resta > 0 ? resta : 0,
    cambio,
  };
});

  const calculate = () => {
    pago.value.total = venta.value.total;
    pago.value.resta = venta.value.total - form.value.efectivo - form.value.transferencia - form.value.tarjeta;
    if(pago.value.resta <= 0){
      pago.value.cambio = pago.value.resta * -1
      pago.value.resta = 0
      
    } else {
      pago.value.cambio = 0
    }
    return pago.value;
  }
  
  onMounted(() => {
    fetchVenta();
  });
  </script>