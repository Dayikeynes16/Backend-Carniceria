import { ref, computed } from 'vue';
import { getSales } from '../services/AxiosVentas';
import { getPendientes } from '../services/AxiosVentas';
import { supabase } from '../connection';
import axios from '../axios';

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
      if (filtroActivo.value === 'todos') {
        data = await getSales();
      } else if (filtroActivo.value === 'activo') {
        data
      } else if (filtroActivo.value === 'en proceso') {
        data = await getPendientes()
      }
      pedidos.value = data;

    } catch (err) {
      error.value = true;
    } finally {
      cargando.value = false;
      subscribeToRealtime()
    }
  };

  const subscribeToRealtime = () => {
    supabase
      .channel('realtime-ventas')
      .on(
        'postgres_changes', { event: 'INSERT', schema: 'public', table: 'ventas' }, async (payload) => {
          try {
            const response = await axios.get(`/venta/${payload.new.id}`);
            pedidos.value.unshift(response.data.data);
          } catch (error) {
            console.error('Error al obtener la venta nueva:', error);
          }
        }
      )
      .on('postgres_changes', { event: 'DELETE', schema: 'public', table: 'ventas' }, (payload) => {
        console.log(pedidos);
        console.log('Post eliminado:', payload.old);
        pedidos.value = posts.value.filter(venta => venta.id !== payload.old.id);
      })
      .subscribe();
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
