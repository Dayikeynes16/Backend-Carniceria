<template>
    <v-container>
        <v-row>
            <v-col cols="6">
               <PedidosPendientesList></PedidosPendientesList>
            </v-col>
            <v-col cols="6">
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
    </v-container>
</template>

<script setup>
import PedidosPendientesList from "../../Components/PedidosPendientesList.vue";


</script>
