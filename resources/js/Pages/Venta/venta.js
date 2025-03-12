import { ref, onMounted } from "vue";
import axios from "../../axios";
import VentaDetalles from "../../Components/VentaDetalles/VentaDetalles.vue";
import overlay from "../../Components/overlay.vue";
import DetalleVenta from "../../Components/DetalleVenta.vue";

export default {
	components: {
        VentaDetalles,
        overlay,
        DetalleVenta,
    },
    setup() {
        const ventas = ref([]);
        const filtro = ref("activas");
        const OverlayValue = ref(false);

        const getPendientes = async () => {
            try {
                OverlayValue.value = true;
                filtro.value = "pendientes";
                const { data } = await axios.get("/pendiente");
                ventas.value = data.data.map((venta) => ({
                    ...venta,
                    dialog: false,
                }));
                console.log('Pendientes',ventas.value);
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
                
                ventas.value = data.data.map((venta) => ({
                    ...venta,
                    dialog: false,
                }));
            } catch (error) {
                console.error("Error al obtener ventas activas:", error);
            } finally {
                OverlayValue.value = false;
            }
        };

        onMounted(() => {
            getSales();
        });

		return { ventas, filtro, getPendientes, getSales, OverlayValue };
    },
};
