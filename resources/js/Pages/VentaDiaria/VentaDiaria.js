export default {
  data() {
    return {
      pedidos: [
        {
          id: "PED-001",
          cliente: "María González",
          fecha: "10/03/2025",
          total: "$156.99",
          estado: "activo",
          productos: 3,
          direccion: "Calle Principal 123, Madrid",
          valorNumerico: 156.99
        },
        {
          id: "PED-002",
          cliente: "Juan Pérez",
          fecha: "09/03/2025",
          total: "$89.50",
          estado: "pendiente",
          productos: 2,
          direccion: "Avenida Central 45, Barcelona",
          valorNumerico: 89.50
        },
        {
          id: "PED-003",
          cliente: "Ana Rodríguez",
          fecha: "08/03/2025",
          total: "$210.75",
          estado: "activo",
          productos: 5,
          direccion: "Plaza Mayor 7, Valencia",
          valorNumerico: 210.75
        },
        {
          id: "PED-004",
          cliente: "Carlos Martínez",
          fecha: "07/03/2025",
          total: "$45.25",
          estado: "pendiente",
          productos: 1,
          direccion: "Calle Nueva 22, Sevilla",
          valorNumerico: 45.25
        },
        {
          id: "PED-005",
          cliente: "Laura Sánchez",
          fecha: "06/03/2025",
          total: "$178.30",
          estado: "activo",
          productos: 4,
          direccion: "Avenida del Mar 15, Málaga",
          valorNumerico: 178.30
        },
        {
          id: "PED-006",
          cliente: "Miguel Fernández",
          fecha: "05/03/2025",
          total: "$67.80",
          estado: "pendiente",
          productos: 2,
          direccion: "Calle Ancha 33, Bilbao",
          valorNumerico: 67.80
        },
      ]
    }
  },
  computed: {
    totalVentas() {
      return this.pedidos.reduce((total, pedido) => {
        return total + pedido.valorNumerico;
      }, 0);
    }
  },
  methods: {
    formatearPrecio(precio) {
      return `$${precio.toFixed(2)}`;
    },
    verDetallesPedido(idPedido) {
      console.log(`Ver detalles del pedido: ${idPedido}`);
    }
  }
}