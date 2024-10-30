<template>
    
       
            
        <v-row class="pa-5">
            <v-col  class=" d-flex justify-space-between align-center">
            <h1 class="text-h3 font-weight-bold" >Información del Cliente</h1>
            <v-btn variant="flat"  color="black">Editar Cliente</v-btn>
            </v-col>
        </v-row>
     
        
            <v-row class="ma-4">
              <v-col cols="8" >
                <v-card elevation="6" height="200" class="">
                  <v-card-title  class="ma-2">Datos Personales</v-card-title>
                  <v-card-text>
                    <v-row class="d-flex align-center">
                      <v-col cols="2">
                        <v-icon class="ma-4" size="65" icon="mdi-account-circle-outline" alt="Client avatar" />
                      </v-col>
                      <v-col cols="10" align-text="left">
                
                        <h2 class="text-h5 font-weight-semibold">{{cliente.nombre}}</h2>
                        <p class="text-body-2">{{ cliente.direccion }}</p>
                        <p class="text-body-2">{{ cliente.telefono }}</p>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
        
              <v-col cols="4">
                <v-card elevation="6" height="200" :disabled="!cliente.credito">
                  <v-card-title>Credit Balance</v-card-title>
                  <v-card-subtitle v-if="cliente.credito === false">
                    Este cliente no cuenta con ningun credito.
                  </v-card-subtitle>
                  <v-card-text >
                    <h3 class="text-h4 font-weight-bold">{{ formatCurrency(parseFloat(cliente.monto)) }}</h3>
                    <v-progress-linear value="50" class="mt-2"></v-progress-linear>
                    <p class="text-caption mt-2">50% of credit limit used</p>
                  </v-card-text>
                </v-card>
               
              </v-col>
            </v-row>
            <v-row class="ma-7">
              <v-card elevation="6" class="" width="100%">
                <v-card-title>Shops</v-card-title>
                <v-card-text>
                  <v-table>
                    <thead>
                      <tr>
                        <th>Shop Name</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Monthly Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="font-weight-medium">Downtown Boutique</td>
                        <td>New York, NY</td>
                        <td><v-chip>Active</v-chip></td>
                        <td>$12,500</td>
                      </tr>
                      <tr>
                        <td class="font-weight-medium">Sunset Shop</td>
                        <td>Los Angeles, CA</td>
                        <td><v-chip color="grey">Pending</v-chip></td>
                        <td>$8,200</td>
                      </tr>
                      <tr>
                        <td class="font-weight-medium">Harbor View Store</td>
                        <td>Seattle, WA</td>
                        <td><v-chip>Active</v-chip></td>
                        <td>$10,800</td>
                      </tr>
                    </tbody>
                  </v-table>
                </v-card-text>
              </v-card>
        
            </v-row>
            <v-row class="ma-4" >
              <v-col cols="3" md="6" lg="3">
                <v-card width="100%" elevation="6">
                  <v-card-title class="d-flex justify-space-between">
                    <span>Total Revenue</span>
                    <v-icon>mdi-currency-usd</v-icon>
                  </v-card-title>
                  <v-card-text>
                    <h2 class="text-h5 font-weight-bold">$45,231.89</h2>
                    <p class="text-caption">+20.1% from last month</p>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="3" md="6" lg="3">
                <v-card width="100%" elevation="6">
                  <v-card-title class="d-flex justify-space-between">
                    <span>Active Shops</span>
                    <v-icon>mdi-store</v-icon>
                  </v-card-title>
                  <v-card-text>
                    <h2 class="text-h5 font-weight-bold">3</h2>
                    <p class="text-caption">+1 this quarter</p>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="3" md="6" lg="3">
                <v-card width="100%" elevation="6">
                  <v-card-title class="d-flex justify-space-between">
                    <span>Total Products</span>
                    <v-icon>mdi-package-variant</v-icon>
                  </v-card-title>
                  <v-card-text>
                    <h2 class="text-h5 font-weight-bold">1,429</h2>
                    <p class="text-caption">+185 new this month</p>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="3" md="6" lg="3">
                <v-card width="100%" elevation="6">
                  <v-card-title class="d-flex justify-space-between">
                    <span>Customer Satisfaction</span>
                    <v-icon>mdi-trending-up</v-icon>
                  </v-card-title>
                  <v-card-text>
                    <h2 class="text-h5 font-weight-bold">98%</h2>
                    <p class="text-caption">+2% from last month</p>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-card class="ma-6 pr-6"  elevation="6">
                  <v-card-title>Actividad Reciente</v-card-title>
                  <v-card-text>
                    <v-list>
                      <v-list-item>
                        <v-icon left>mdi-shopping</v-icon>
                        <v-list-item-content>
                          <v-list-item-title>New order placed</v-list-item-title>
                          <v-list-item-subtitle>Order #12345 - $230.00</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-content class="text-caption">2 hours ago</v-list-item-content>
                      </v-list-item>
            
                      <v-list-item>
                        <v-icon left>mdi-account</v-icon>
                        <v-list-item-content>
                          <v-list-item-title>Customer details updated</v-list-item-title>
                          <v-list-item-subtitle>Changed shipping address</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-content class="text-caption">Yesterday</v-list-item-content>
                      </v-list-item>
            
                      <v-list-item>
                        <v-icon left>mdi-credit-card</v-icon>
                        <v-list-item-content>
                          <v-list-item-title>Credit limit increased</v-list-item-title>
                          <v-list-item-subtitle>New limit: $10,000</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-content class="text-caption">3 days ago</v-list-item-content>
                      </v-list-item>
                    </v-list>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>

  </template>
  
  <script setup>
import { onMounted, ref , onBeforeMount } from 'vue';
import { useRoute } from 'vue-router';
import formatCurrency from '../composables/FormatCurrency';
const route = useRoute();
const id = route.params.id;  // Acceder al ID desde los parámetros de la URL
const cliente = ref({});
const  name = ref('ClientInfoPage')

import axios from 'axios'


const getClientInformation = async () => {
  axios.get(`/client-back/${id}`).then(({ data }) => {
    cliente.value = data.data; 
    console.log(cliente.value);// Suponiendo que el endpoint te devuelve los detalles del cliente
    if(cliente.credito === false){
      clientCredit.value = false
    }
  });

}

const clientCredit = ref()

onBeforeMount(() => {
  getClientInformation()

  console.log('hola hijeputa',id);
});
  </script>
  