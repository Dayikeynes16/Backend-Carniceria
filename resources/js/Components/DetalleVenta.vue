<template>
    <v-card class="order-details">
        <v-card-title class="font-weight-bold"
            >Detalles del Pedido</v-card-title
        >
        <v-card-text>
            <v-list>
                <v-list-item v-for="(item, index) in orderDetails" :key="index">
                    <v-list-item-content>
                        <v-list-item-title>{{
                            item.producto
                        }}</v-list-item-title>
                        <v-list-item-subtitle>
                            Cantidad: {{ item.cantidad }}kg, Precio: ${{
                                item.precio
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="font-weight-bold"
                        >Total</v-list-item-title
                    >
                    <v-list-item-subtitle>${{ total }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: {
        orderDetails: {
            type: Array,
            required: true,
        },
        total: {
            type: Number,
            required: true,
        },
    },
};
</script>

<style scoped>
.order-details {
    position: fixed;
    right: 0;
    top: 0;
    width: 400px;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
    background-color: white;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
}
</style>
