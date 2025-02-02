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
                            Card title
                        </v-card-title>

                        <v-card-subtitle>
                            Card subtitle secondary text
                        </v-card-subtitle>

                        <template v-slot:append>
                            <v-icon
                                color="black"
                                icon="mdi-information-outline"
                            ></v-icon>
                        </template>
                    </v-card-item>

                    <v-card-text class="justify-content">
                        <span>10/03/2024</span>
                        <span>10:30 am</span>
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

<script setup>
import { ref, onMounted } from "vue";
import axios from "../axios";
import VentaDetalles from "../Components/VentaDetalles.vue";
import overlay from "../Components/overlay.vue";

const ventas = ref([]);
const filtro = ref("activas");
const OverlayValue = ref(false);

const getPendientes = async () => {
    try {
        OverlayValue.value = true;
        filtro.value = "pendientes";
        const { data } = await axios.get("/api/sapo/pendiente");
        ventas.value = data.data.map((venta) => ({ ...venta, dialog: false }));
    } catch (error) {
        console.error("Error al obtener ventas pendientes:", error);
    } finally {
        OverlayValue.value = false;
    }
};

const getSales = async () => {
    try {
        OverlayValue.value = true;
        filtro.value = "activas";
        const { data } = await axios.get("/venta");
        ventas.value = data.data.map((venta) => ({ ...venta, dialog: false }));
    } catch (error) {
        console.error("Error al obtener ventas activas:", error);
    } finally {
        OverlayValue.value = false;
    }
};

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
    getSales();
});
</script>

<style scoped>
.justify-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  opacity: 0.5;
}
</style>