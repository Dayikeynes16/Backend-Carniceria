<template>
    <v-container>
        <v-card class="pa-4 mb-4">
            <v-card-title class="font-weight-bold">Filtrar Ventas</v-card-title>
            <v-row>
                <v-col cols="6">
                    <v-btn
                        block
                        :color="filtro === 'activas' ? 'primary' : 'grey'"
                        @click="getSales"
                    >
                        Ventas Activas
                    </v-btn>
                </v-col>
                <v-col cols="6">
                    <v-btn
                        block
                        :color="filtro === 'pendientes' ? 'primary' : 'grey'"
                        @click="getPendientes"
                    >
                        Ventas Pendientes
                    </v-btn>
                </v-col>
            </v-row>
        </v-card>

        <v-row justify="start">
            <v-col
                v-for="venta in ventas"
                :key="venta.id"
                cols="12"
                sm="6"
                md="4"
                lg="3"
            >
                <v-card
                    @click="venta.dialog = true"
                    max-width="344"
                    class="mx-auto"
                >
                    <v-card-item>
                        <v-card-title class="font-weight-bold">
                            Orden #{{venta.id}}
                        </v-card-title>

                        <v-card-subtitle>
                            Articulos: {{ venta.productos.length }}
                        </v-card-subtitle>

                        <template v-slot:append>
                            <v-icon
                                color="black"
                                icon="mdi-information-outline"
                            ></v-icon>
                        </template>
                    </v-card-item>

                    <v-card-text class="justify-content">
                        <span>{{ venta.created_at.split('T')[0] }}</span>
                        <span>{{ venta.created_at.split('T')[1].split('.')[0] }}</span>
                    </v-card-text>
                </v-card>

                <v-dialog v-model="venta.dialog" max-width="600">
                    <VentaDetalles
                        @deleted="getSales"
                        @cerrar="venta.dialog = false"
                        :id="venta.id"
                    />
                </v-dialog>
            </v-col>
        </v-row>

        <overlay :activo="OverlayValue"></overlay>
    </v-container>
</template>

<script src="./venta.js"></script>

<style scoped>
.justify-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    opacity: 0.5;
}
</style>
