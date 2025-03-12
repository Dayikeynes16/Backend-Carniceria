import { ref } from 'vue';

export function useOrdenamiento() {
  const ordenActual = ref(null);
  const opcionesFiltro = [
    { texto: 'Más recientes', valor: 'recientes' },
    { texto: 'Más antiguos', valor: 'antiguos' },
    { texto: 'Mayor importe', valor: 'mayor' },
    { texto: 'Menor importe', valor: 'menor' }
  ];

  const ordenarPor = (criterio) => {
    ordenActual.value = criterio;
  };

  const ordenarLista = (lista, criterio) => {
    const listaOrdenada = [...lista];

    switch (criterio) {
      case 'recientes':
        return listaOrdenada.sort((a, b) => convertirFecha(b.created_at) - convertirFecha(a.created_at));
      case 'antiguos':
        return listaOrdenada.sort((a, b) => convertirFecha(a.created_at) - convertirFecha(b.created_at));
      case 'mayor':
        return listaOrdenada.sort((a, b) => extraerNumero(b.total) - extraerNumero(a.total));
      case 'menor':
        return listaOrdenada.sort((a, b) => extraerNumero(a.total) - extraerNumero(b.total));
      default:
        return listaOrdenada;
    }
  };

  const convertirFecha = (fechaStr) => {
    const partes = fechaStr.split('/');
    return new Date(partes[2], partes[1] - 1, partes[0]);
  };

  const extraerNumero = (precioStr) => {
    return parseFloat(precioStr.replace('$', '').replace(',', '.'));
  };

  return {
    ordenActual,
    opcionesFiltro,
    ordenarPor,
    ordenarLista
  };
}
