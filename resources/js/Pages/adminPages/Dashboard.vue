<template>

        <v-row>
            <v-col class="ma-4" cols="6">
               <PedidosPendientesList></PedidosPendientesList>
            </v-col>
            <v-col class="ma-4" cols="5">
                <v-card color="">
                    <v-card-title>
                        <v-text>Envios Pendientes</v-text>
                    </v-card-title>
                    <v-card-text>
                        <v-text>No hay envios pendientes</v-text>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

</template>

<script setup>
import PedidosPendientesList from "../../Components/PedidosPendientesList.vue";


</script>
