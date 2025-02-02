<template>
  <v-container>
    <v-row class="pa-5">
        <v-col class="d-flex justify-space-between align-center">
            <h1 class="text-h3 font-weight-bold">Información del Cliente</h1>
            <v-btn variant="flat" color="black" @click="AddDiscount = true"
                >Añadir Descuento</v-btn
            >
            <v-dialog v-model="AddDiscount" max-width="500">
                <PrecioEspecial
                    @cancelado="AddDiscount = false"
                    :update="Update"
                    :id="cliente.id"
                    :producto="UpdateProduct"
                    @cerrar="closeDiscountSection()"
                ></PrecioEspecial>
            </v-dialog>
        </v-col>
    </v-row>

    <v-row class="ma-4">
        <v-col cols="8">
            <v-card elevation="6" height="200" class="">
                <v-card-title class="ma-2">Datos Personales</v-card-title>
                <v-card-text>
                    <v-row class="d-flex align-center">
                        <v-col cols="2">
                            <v-icon
                                class="ma-4"
                                size="65"
                                icon="mdi-account-circle-outline"
                                alt="Client avatar"
                            />
                        </v-col>
                        <v-col cols="10" align-text="left">
                            <h2 class="text-h5 font-weight-semibold">
                                {{ cliente.nombre }}
                            </h2>
                            <p class="text-body-2">
                                Dirección: {{ cliente.direccion }}
                            </p>
                            <p class="text-body-2">
                                Telefono: {{ cliente.telefono }}
                            </p>
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
                <v-card-text>
                    <h3 class="text-h4 font-weight-bold">
                        {{ formatCurrency(parseFloat(cliente.monto)) }}
                    </h3>
                    <v-progress-linear
                        value="50"
                        class="mt-2"
                    ></v-progress-linear>
                    <p class="text-caption mt-2">50% of credit limit used</p>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
    <v-row class="ma-7">
        <v-card elevation="6" class="" width="100%">
            <v-card-title>Compras recientes</v-card-title>
            <v-card-text>
                <v-table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in ventas">
                            <td>
                                {{ formatRelativeTime(i.created_at) }}
                            </td>
                            <td>
                                {{ formatCurrency(i.total) }}
                            </td>
                            <td>
                                <span v-if="i.pagado">Pagado</span>
                                <span v-else>Pendiente</span>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-card-text>
        </v-card>
    </v-row>
    <v-row class="ma-4">
        <v-col cols="3" md="6" lg="3">
            <v-card width="100%" elevation="6">
                <v-card-title class="d-flex justify-space-between">
                    <span>Gasto Mensual</span>
                    <v-icon>mdi-currency-usd</v-icon>
                </v-card-title>
                <v-card-text>
                    <h2 class="text-h5 font-weight-bold">
                        {{ formatCurrency(saled_last_month) }}
                    </h2>
                    <!-- <p class="text-caption">+20.1% from last month</p> -->
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="6" md="6" lg="3">
            <v-card width="100%" elevation="6">
                <v-card-title class="d-flex justify-space-between">
                    <span class="">Pendientes</span>
                    <v-icon>mdi-store</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            <span class="text-h7 font-weight-bold"
                                >Ventas Pendientes</span
                            >
                        </v-col>
                        <v-col cols="6">
                            <span class="text-h7 font-weight-bold">Total</span>
                        </v-col>
                        <v-col cols="6">
                            <span class="text-wrap text-subtitle-1">{{
                                ventas.active_sales
                            }}</span>
                        </v-col>
                        <v-col cols="6">
                            <span class="text-wrap text-subtitle-1">{{
                                formatCurrency(total_pendiente)
                            }}</span>
                        </v-col>
                    </v-row>

                    <!-- <p class="text-caption">+1 this quarter</p> -->
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
                    <h2 class="text-h5 font-weight-bold">fd</h2>
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
            <v-card class="ma-6 pr-6" elevation="6">
                <v-card-title>Descuentos</v-card-title>
                <v-card-text>
                    <v-table>
                        <thead>
                            <tr>
                                <td>Producto</td>
                                <td>Precio Original</td>
                                <td>Precio con descuento</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="i in cliente.descuentos">
                                <th>
                                    {{ i.producto.nombre }}
                                </th>
                                <th>
                                    {{
                                        formatCurrency(
                                            i.producto.precio_de_venta
                                        )
                                    }}
                                </th>
                                <th>
                                    {{ formatCurrency(i.precio) }}
                                </th>
                                <th>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-icon
                                                color="red"
                                                icon="mdi-pencil"
                                                @click="editProduct(i)"
                                                class="cursor-pointer"
                                            >
                                            </v-icon>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-icon
                                                icon="mdi-delete"
                                                class="cursor-pointer"
                                                @click="deleteDiscount(i)"
                                            >
                                            </v-icon>
                                        </v-col>
                                    </v-row>
                                </th>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
    <overlay :activo="activo"></overlay>
  </v-container>
</template>

<script setup>
import { onMounted, ref, onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import formatCurrency from "../composables/FormatCurrency";
import overlay from "../Components/overlay.vue";
import { ElMessage } from "element-plus";

const route = useRoute();
const id = route.params.id; // Acceder al ID desde los parámetros de la URL
const cliente = ref({});
const name = ref("ClientInfoPage");
const ventas = ref([]);
const Update = ref(false);
const loading = ref(true);
const UpdateProduct = ref({});
import "dayjs/locale/es";
import localeData from "dayjs/plugin/localeData";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(localeData);
dayjs.extend(relativeTime);
dayjs.locale("es");

import axios from "axios";
import PrecioEspecial from "./PrecioEspecial.vue";
import { fa } from "vuetify/locale";
const saled_last_month = ref(0);
const activo = ref(false);
const total_pendiente = ref(0);

const getClientInformation = async () => {
    activo.value = true;
    axios.get(`/client-back/${id}`).then(({ data }) => {
        activo.value = false;

        cliente.value = data.data;
        ventas.value = data.ventas.data;
        ventas.value.active_sales = 0;
        total_pendiente.value = data.total_pendiente;
        saled_last_month.value = data.vendido_ultimo_mes;

        ventas.value.forEach((venta) => {
            if (venta.pagado === false) {
                ventas.value.active_sales += 1;
            }
        });

        loading.value = false;
        if (cliente.credito === false) {
            clientCredit.value = false;
        }
        activo.value = false;
    });
};

const formatRelativeTime = (fecha) => {
    return dayjs(fecha).fromNow();
};

const deleteDiscount = async (item) => {
    try {
        activo.value = true;

        const { data } = await axios.delete(`/api/precio-especial/${item.id}`);
        ElMessage({
            type: "success",
            message: "Borrado Exitosamente",
        });
        activo.value = false;

        getClientInformation();
    } catch (error) {
        ElMessage.error("Algo salió mal");
        activo.value = false;
    }
};

const clientCredit = ref();
const AddDiscount = ref(false);

const editProduct = (item) => {
    Update.value = true;
    UpdateProduct.value = item;
    AddDiscount.value = true;
};

const closeDiscountSection = () => {
    UpdateProduct.value = {};

    AddDiscount.value = false;
    Update.value = false;
    getClientInformation();
};

onBeforeMount(() => {
    getClientInformation();
});
</script>
