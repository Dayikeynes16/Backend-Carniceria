<template>
    <v-container>
        <v-card-actions> </v-card-actions>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>cantidad</th>
                    <th>Eliminar</th>
                    <th>total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in productos_carrito" :key="item.id">
                    <td>
                        <span>{{ item.nombre }}</span>
                    </td>
                    <td>
                        <v-btn
                            @click="restarCantidad(item)"
                            icon="mdi-minus"
                        ></v-btn>
                        <span>{{ item.cantidad }}</span>
                        <v-btn
                            @click="sumarCantidad(item)"
                            icon="mdi-plus"
                        ></v-btn>
                    </td>
                    <td>
                        <v-btn
                            @click="borrarProducto(item.id)"
                            icon="mdi-delete"
                            color="red"
                        ></v-btn>
                    </td>
                    <td>
                        <span>{{
                            Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: "MXN",
                                minimumFractionDigits: 2,
                            }).format(item.precio)
                        }}</span>
                    </td>
                </tr>
                <tr v-for="file in files" :key="file.id">
                    <td>
                        <span>{{ file.nombre }}</span>
                    </td>
                    <td>
                        <v-btn
                            @click="restarCantidadFile(file)"
                            icon="mdi-minus"
                        ></v-btn>
                        <span>{{ file.cantidad }}</span>
                        <v-btn
                            @click="sumarCantidadFile(file)"
                            icon="mdi-plus"
                        ></v-btn>
                    </td>
                    <td>
                        <v-btn
                            @click="borrarFile(file.id)"
                            icon="mdi-delete"
                            color="red"
                        ></v-btn>
                    </td>
                    <td>
                        <span>{{
                            Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: "MXN",
                                minimumFractionDigits: 2,
                            }).format(file.precio)
                        }}</span>
                    </td>

                </tr>
            </tbody>
        </table>
        <v-card-actions>
            <v-btn @click="router.push({name:'CarritoFinal'})"  text="Proceder con la compra"></v-btn>
          </v-card-actions>
    </v-container>
</template>
<script setup>
import { ref, watch, onMounted } from "vue";
import { useCartStore } from "../stores/carrito";
import axios from "axios";
import { useRouter } from 'vue-router';
const router = useRouter();

const cartStore = useCartStore();
const token = document.querySelector("meta[name='csrf-token']").getAttribute("value");

const productos_carrito = ref([]);
const files = ref([]);

const fetchProductosCarrito = () => {
    productos_carrito.value = cartStore.items.map((item) => ({
        id: item.id,
        nombre: item.producto.name,
        cantidad: item.cantidad,
        precio: item.total,
    }));

    files.value = cartStore.files.map((file) => ({
        id: file.id,
        nombre: file.nombre,
        cantidad: file.cantidad,
        precio: file.precio
    }));
};

const updateCart = async () => {
    await cartStore.fetchCart();
    fetchProductosCarrito();
};

watch(() => cartStore.items, fetchProductosCarrito, { immediate: true });

const restarCantidad = async (item) => {
    if (item.cantidad > 1) {
        item.cantidad--;
        await axios.post(
            "/actualizarProductoCarrito",
            { id: item.id, cantidad: item.cantidad },
            { headers: { "X-CSRF-TOKEN": token } }
        );
        updateCart();
    }
};

const sumarCantidad = async (item) => {
    item.cantidad++;
    await axios.post(
        "/actualizarProductoCarrito",
        { id: item.id, cantidad: item.cantidad },
        { headers: { "X-CSRF-TOKEN": token } }
    );
    updateCart();
};

const borrarProducto = async (id) => {
    try {
        await axios.post(
            "/borrarProducto",
            { id },
            { headers: { "X-CSRF-TOKEN": token } }
        );
        updateCart();
    } catch (error) {
        console.error("Error deleting product:", error);
    }
};

const borrarFile = async (id) => {
    try {
        await axios.post(
            "/deletefile",
            { id },
            { headers: { "X-CSRF-TOKEN": token } }
        );
        updateCart();
    } catch (error) {
        console.error("Error deleting file:", error);
    }
};

const sumarCantidadFile = async (file) => {
    file.cantidad++;
    await axios.post(
        "/actualizarFileCarrito",
        { id: file.id, cantidad: file.cantidad },
        { headers: { "X-CSRF-TOKEN": token } }
    );
    updateCart();
};

const restarCantidadFile = async (file) => {
    if (file.cantidad > 1) {
        file.cantidad--;
        await axios.post(
            "/actualizarFileCarrito",
            { id: file.id, cantidad: file.cantidad },
            { headers: { "X-CSRF-TOKEN": token } }
        );
        updateCart();
    }
};

onMounted(updateCart);
</script>

