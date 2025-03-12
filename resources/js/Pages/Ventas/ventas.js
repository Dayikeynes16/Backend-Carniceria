import { usePedidos } from "../../composables/usePedidos";
import { useOrdenamiento } from "../../composables/useOrdenamiento";
import { computed, watch } from "vue";
import overlay from "../../Components/overlay.vue";

export default {
  components: {
    overlay
  },
  setup() {

    const { 
      filtroActivo, busqueda,
      pedidosFiltrados, cargarPedidos,
      cargando, error } = usePedidos();

    const { ordenActual, opcionesFiltro, ordenarPor, ordenarLista } = useOrdenamiento();

    const pedidosOrdenados = computed(() => {
      return ordenActual.value ? ordenarLista(pedidosFiltrados.value, ordenActual.value) : pedidosFiltrados.value;
    });

    watch(filtroActivo, cargarPedidos, { immediate: true });

    return {
      filtroActivo,
      busqueda,
      pedidosOrdenados,
      opcionesFiltro,
      ordenarPor,
      cargando,
      error,
      cargarPedidos
    };
  }
};