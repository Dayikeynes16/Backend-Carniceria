import { ref, computed } from 'vue';
import { getSales } from '../services/AxiosVentas';
import { getPendientes } from '../services/AxiosVentas';

export function usePedidos() {
  const filtroActivo = ref('todos');
  const busqueda = ref('');
  const pedidos = ref([]);
  const cargando = ref(false);
  const error = ref(false);

  const cargarPedidos = async () => {
    cargando.value = true;
    error.value = false;
    try {
      let data
      if (filtroActivo.value === 'todos'){
        data = await getSales();
      } else if (filtroActivo.value === 'activo'){
        data
      } else if(filtroActivo.value === 'en proceso') {
        data = await getPendientes()
      }
      pedidos.value = data;

    } catch (err) {
      error.value = true;
    } finally {
      cargando.value = false;
    }
  };

  const pedidosFiltrados = computed(() => {
    return pedidos.value.filter(pedido => {
      const coincideFiltro = filtroActivo.value === 'todos' || pedido.estatus === filtroActivo.value;
      const coincideBusqueda = String(pedido.balanza).toLocaleLowerCase().includes(busqueda.value).toLocaleLowerCase ||
        String(pedido.id).includes(busqueda.value);
      return coincideFiltro && coincideBusqueda;
    });
  });

  return {
    filtroActivo,
    busqueda,
    pedidos,
    pedidosFiltrados,
    cargarPedidos,
    cargando,
    error
  };
}
