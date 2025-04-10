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
      pedidos,
      cargando, error } = usePedidos();

    const { ordenActual, opcionesFiltro, ordenarPor, ordenarLista } = useOrdenamiento();

    const pedidosOrdenados = computed(() => {
      const listaFiltrada = pedidosFiltrados.value;
      console.log('Lista', listaFiltrada);
      return ordenActual.value ? ordenarLista(listaFiltrada, ordenActual.value) : listaFiltrada;
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