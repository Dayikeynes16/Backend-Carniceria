<template>
  <v-container>
    <!-- Encabezado -->
    <v-row>
      <v-col cols="12" class="d-flex justify-space-between align-center">
        <div>
          <h1 class="text-h4 font-weight-bold mb-1">Detalles del Pedido</h1>
          <p class="text-subtitle-1 text-medium-emphasis">
            {{ pedido.id }} - {{ formatearFecha(pedido.fecha) }}
          </p>
        </div>
        <v-chip :color="pedido.estado === 'activo' ? 'primary' : 'grey'"
          :text-color="pedido.estado === 'activo' ? 'white' : ''">
          <v-icon size="small" start>
            {{ pedido.estado === 'activo' ? 'mdi-check-circle' : 'mdi-clock-outline' }}
          </v-icon>
          {{ pedido.estado === 'activo' ? 'Activo' : 'Pendiente' }}
        </v-chip>
      </v-col>
    </v-row>

    <!-- Información del cliente -->
    <v-row>
      <v-col cols="12">
        <v-card variant="outlined" class="mb-6">
          <v-card-item>
            <template v-slot:prepend>
              <v-icon size="large" color="primary">mdi-account</v-icon>
            </template>
            <v-card-title>Información del Cliente</v-card-title>
          </v-card-item>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="6">
                <div class="text-subtitle-2 text-medium-emphasis mb-1">Nombre</div>
                <div class="text-body-1 mb-3">{{ pedido.cliente }}</div>

                <div class="text-subtitle-2 text-medium-emphasis mb-1">Teléfono</div>
                <div class="text-body-1">{{ pedido.telefono }}</div>
              </v-col>
              <v-col cols="12" md="6">
                <div class="text-subtitle-2 text-medium-emphasis mb-1">Dirección de Entrega</div>
                <div class="text-body-1 mb-3">{{ pedido.direccion }}</div>

                <div class="text-subtitle-2 text-medium-emphasis mb-1">Email</div>
                <div class="text-body-1">{{ pedido.email }}</div>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Lista de productos -->
    <v-row>
      <v-col cols="12">
        <v-card variant="outlined" class="mb-6">
          <v-card-item>
            <template v-slot:prepend>
              <v-icon size="large" color="primary">mdi-package-variant</v-icon>
            </template>
            <v-card-title>Productos del Pedido</v-card-title>
            <template v-slot:append>
              <v-btn color="primary" variant="text" prepend-icon="mdi-plus"
                @click="mostrarDialogoAgregarProducto = true">
                Agregar Producto
              </v-btn>
            </template>
          </v-card-item>

          <v-data-table :headers="encabezadosTabla" :items="pedido.productos" :items-per-page="5" class="elevation-0">
            <template v-slot:item.imagen="{ item }">
              <v-avatar size="40">
                <v-img :src="item.imagen" :alt="item.nombre"></v-img>
              </v-avatar>
            </template>

            <template v-slot:item.descuento="{ item }">
              <v-chip v-if="item.descuento > 0" color="success" size="small" variant="outlined">
                -{{ item.descuento }}%
              </v-chip>
              <span v-else>-</span>
            </template>

            <template v-slot:item.precioFinal="{ item }">
              <span class="font-weight-bold">{{ formatearPrecio(item.precioFinal) }}</span>
            </template>

            <template v-slot:item.acciones="{ item }">
              <v-btn icon variant="text" color="error" size="small" @click="confirmarEliminarProducto(item)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>

    <!-- Resumen y totales -->
    <v-row>
      <v-col cols="12" md="6">
        <v-card variant="outlined" class="mb-6">
          <v-card-item>
            <template v-slot:prepend>
              <v-icon size="large" color="primary">mdi-note-text</v-icon>
            </template>
            <v-card-title>Notas del Pedido</v-card-title>
          </v-card-item>
          <v-card-text>
            <v-textarea v-model="pedido.notas" rows="4" variant="outlined"
              placeholder="Añadir notas al pedido..."></v-textarea>
            <v-btn variant="tonal" color="primary" size="small" prepend-icon="mdi-content-save">
              Guardar Notas
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <v-card variant="outlined" class="mb-6">
          <v-card-item>
            <template v-slot:prepend>
              <v-icon size="large" color="primary">mdi-cash-multiple</v-icon>
            </template>
            <v-card-title>Resumen del Pedido</v-card-title>
          </v-card-item>
          <v-card-text>
            <v-list>
              <v-list-item>
                <template v-slot:prepend>
                  <div class="text-subtitle-1">Subtotal</div>
                </template>
                <template v-slot:append>
                  <div class="text-subtitle-1">{{ formatearPrecio(calcularSubtotal()) }}</div>
                </template>
              </v-list-item>

              <v-list-item>
                <template v-slot:prepend>
                  <div class="text-subtitle-1">Descuentos</div>
                </template>
                <template v-slot:append>
                  <div class="text-subtitle-1 text-error">-{{ formatearPrecio(calcularDescuentos()) }}</div>
                </template>
              </v-list-item>

              <v-list-item>
                <template v-slot:prepend>
                  <div class="text-subtitle-1">Impuestos ({{ pedido.impuestos }}%)</div>
                </template>
                <template v-slot:append>
                  <div class="text-subtitle-1">{{ formatearPrecio(calcularImpuestos()) }}</div>
                </template>
              </v-list-item>

              <v-list-item>
                <template v-slot:prepend>
                  <div class="text-subtitle-1">Envío</div>
                </template>
                <template v-slot:append>
                  <div class="text-subtitle-1">{{ formatearPrecio(pedido.costoEnvio) }}</div>
                </template>
              </v-list-item>

              <v-divider class="my-2"></v-divider>

              <v-list-item>
                <template v-slot:prepend>
                  <div class="text-h6 font-weight-bold">Total</div>
                </template>
                <template v-slot:append>
                  <div class="text-h6 font-weight-bold">{{ formatearPrecio(calcularTotal()) }}</div>
                </template>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Botones de acción -->
    <v-row>
      <v-col cols="12" class="d-flex justify-space-between">
        <div>
          <v-btn color="error" variant="outlined" prepend-icon="mdi-delete" class="mr-2"
            @click="confirmarEliminarPedido">
            Eliminar Pedido
          </v-btn>
          <v-btn color="secondary" variant="outlined" prepend-icon="mdi-arrow-left" @click="volver">
            Volver
          </v-btn>
        </div>
        <v-btn color="primary" size="large" prepend-icon="mdi-cash-register" @click="abrirVentanaPago">
          Proceder al Pago
        </v-btn>
      </v-col>
    </v-row>

    <!-- Diálogo para agregar producto -->
    <v-dialog v-model="mostrarDialogoAgregarProducto" max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Agregar Producto</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-autocomplete v-model="nuevoProducto.id" :items="productosDisponibles" item-title="nombre"
                  item-value="id" label="Seleccionar Producto" variant="outlined" return-object
                  @update:model-value="seleccionarProducto"></v-autocomplete>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="nuevoProducto.cantidad" label="Cantidad" type="number" min="1" variant="outlined"
                  @input="calcularPrecioFinalNuevo"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="nuevoProducto.descuento" label="Descuento (%)" type="number" min="0" max="100"
                  variant="outlined" @input="calcularPrecioFinalNuevo"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="nuevoProducto.precio" label="Precio Unitario" prefix="$" variant="outlined"
                  readonly></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="nuevoProducto.precioFinal" label="Precio Final" prefix="$" variant="outlined"
                  readonly></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" variant="text" @click="mostrarDialogoAgregarProducto = false">
            Cancelar
          </v-btn>
          <v-btn color="primary" @click="agregarProducto" :disabled="!nuevoProducto.id">
            Agregar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Diálogo para confirmar eliminación de producto -->
    <v-dialog v-model="mostrarDialogoEliminarProducto" max-width="400px">
      <v-card>
        <v-card-title class="text-h5">
          Eliminar Producto
        </v-card-title>
        <v-card-text>
          ¿Estás seguro de que deseas eliminar este producto del pedido?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" variant="text" @click="mostrarDialogoEliminarProducto = false">
            Cancelar
          </v-btn>
          <v-btn color="error" @click="eliminarProducto">
            Eliminar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Diálogo para confirmar eliminación del pedido -->
    <v-dialog v-model="mostrarDialogoEliminarPedido" max-width="400px">
      <v-card>
        <v-card-title class="text-h5">
          Eliminar Pedido
        </v-card-title>
        <v-card-text>
          ¿Estás seguro de que deseas eliminar este pedido completo? Esta acción no se puede deshacer.
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" variant="text" @click="mostrarDialogoEliminarPedido = false">
            Cancelar
          </v-btn>
          <v-btn color="error" @click="eliminarPedido">
            Eliminar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Diálogo para pago -->
    <v-dialog v-model="mostrarDialogoPago" max-width="700px">
      <v-card>
        <v-card-title class="text-h5">
          Procesar Pago
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <h3 class="text-h6 mb-4">Total a pagar: {{ formatearPrecio(calcularTotal()) }}</h3>

                <v-tabs v-model="metodoPagoSeleccionado" class="mb-4">
                  <v-tab value="tarjeta">Tarjeta de Crédito</v-tab>
                  <v-tab value="transferencia">Transferencia</v-tab>
                  <v-tab value="efectivo">Efectivo</v-tab>
                </v-tabs>

                <v-window v-model="metodoPagoSeleccionado">
                  <v-window-item value="tarjeta">
                    <v-form>
                      <v-text-field label="Número de Tarjeta" variant="outlined" placeholder="1234 5678 9012 3456"
                        v-model="datosPago.numeroTarjeta"></v-text-field>

                      <v-row>
                        <v-col cols="6">
                          <v-text-field label="Fecha de Expiración" variant="outlined" placeholder="MM/AA"
                            v-model="datosPago.fechaExpiracion"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                          <v-text-field label="CVV" variant="outlined" placeholder="123" v-model="datosPago.cvv"
                            type="password"></v-text-field>
                        </v-col>
                      </v-row>

                      <v-text-field label="Nombre en la Tarjeta" variant="outlined" placeholder="NOMBRE APELLIDO"
                        v-model="datosPago.nombreTarjeta"></v-text-field>
                    </v-form>
                  </v-window-item>

                  <v-window-item value="transferencia">
                    <v-alert type="info" variant="tonal" class="mb-4">
                      Realiza una transferencia a la siguiente cuenta bancaria:
                    </v-alert>

                    <div class="pa-4 bg-grey-lighten-4 rounded mb-4">
                      <p><strong>Banco:</strong> Banco Nacional</p>
                      <p><strong>Titular:</strong> Empresa S.A.</p>
                      <p><strong>Cuenta:</strong> ES12 3456 7890 1234 5678 9012</p>
                      <p><strong>Concepto:</strong> Pedido {{ pedido.id }}</p>
                    </div>

                    <v-file-input label="Comprobante de Transferencia" variant="outlined" prepend-icon="mdi-paperclip"
                      accept="image/*,.pdf"></v-file-input>
                  </v-window-item>

                  <v-window-item value="efectivo">
                    <v-alert type="info" variant="tonal">
                      Has seleccionado pago en efectivo. El repartidor cobrará {{ formatearPrecio(calcularTotal()) }} en
                      el
                      momento de la entrega.
                    </v-alert>
                  </v-window-item>
                </v-window>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" variant="text" @click="mostrarDialogoPago = false">
            Cancelar
          </v-btn>
          <v-btn color="primary" @click="procesarPago">
            Confirmar Pago
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      pedido: {
        id: "PED-001",
        cliente: "María González",
        telefono: "+34 612 345 678",
        email: "maria.gonzalez@ejemplo.com",
        fecha: "2025-03-10",
        estado: "activo",
        direccion: "Calle Principal 123, Madrid, 28001",
        notas: "Entregar en horario de tarde, después de las 16:00h.",
        impuestos: 21,
        costoEnvio: 4.99,
        productos: [
          {
            id: 1,
            nombre: "Camiseta Básica",
            imagen: "/placeholder.svg?height=40&width=40",
            cantidad: 2,
            precio: 19.99,
            descuento: 10,
            precioFinal: 35.98
          },
          {
            id: 2,
            nombre: "Pantalón Vaquero",
            imagen: "/placeholder.svg?height=40&width=40",
            cantidad: 1,
            precio: 49.99,
            descuento: 0,
            precioFinal: 49.99
          },
          {
            id: 3,
            nombre: "Zapatillas Deportivas",
            imagen: "/placeholder.svg?height=40&width=40",
            cantidad: 1,
            precio: 79.99,
            descuento: 15,
            precioFinal: 67.99
          }
        ]
      },
      encabezadosTabla: [
        { title: 'Imagen', key: 'imagen', sortable: false, align: 'center', width: '80px' },
        { title: 'Producto', key: 'nombre', align: 'start' },
        { title: 'Cantidad', key: 'cantidad', align: 'center', width: '100px' },
        { title: 'Precio Unit.', key: 'precio', align: 'end' },
        { title: 'Descuento', key: 'descuento', align: 'center' },
        { title: 'Precio Final', key: 'precioFinal', align: 'end' },
        { title: 'Acciones', key: 'acciones', sortable: false, align: 'center', width: '80px' }
      ],
      productosDisponibles: [
        { id: 4, nombre: 'Sudadera con Capucha', precio: 39.99, imagen: '/placeholder.svg?height=40&width=40' },
        { id: 5, nombre: 'Chaqueta de Invierno', precio: 89.99, imagen: '/placeholder.svg?height=40&width=40' },
        { id: 6, nombre: 'Bufanda de Lana', precio: 19.99, imagen: '/placeholder.svg?height=40&width=40' },
        { id: 7, nombre: 'Gorro de Punto', precio: 14.99, imagen: '/placeholder.svg?height=40&width=40' },
        { id: 8, nombre: 'Calcetines (Pack de 3)', precio: 9.99, imagen: '/placeholder.svg?height=40&width=40' }
      ],
      nuevoProducto: {
        id: null,
        nombre: '',
        imagen: '',
        cantidad: 1,
        precio: 0,
        descuento: 0,
        precioFinal: 0
      },
      productoAEliminar: null,
      mostrarDialogoAgregarProducto: false,
      mostrarDialogoEliminarProducto: false,
      mostrarDialogoEliminarPedido: false,
      mostrarDialogoPago: false,
      metodoPagoSeleccionado: 'tarjeta',
      datosPago: {
        numeroTarjeta: '',
        fechaExpiracion: '',
        cvv: '',
        nombreTarjeta: ''
      }
    }
  },
  methods: {
    formatearFecha(fecha) {
      const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(fecha).toLocaleDateString('es-ES', opciones);
    },
    formatearPrecio(precio) {
      return `$${parseFloat(precio).toFixed(2)}`;
    },
    calcularSubtotal() {
      // Suma de precios sin descuentos
      return this.pedido.productos.reduce((total, producto) => {
        return total + (producto.precio * producto.cantidad);
      }, 0);
    },
    calcularDescuentos() {
      // Total de descuentos aplicados
      return this.pedido.productos.reduce((total, producto) => {
        const precioSinDescuento = producto.precio * producto.cantidad;
        const precioConDescuento = producto.precioFinal;
        return total + (precioSinDescuento - precioConDescuento);
      }, 0);
    },
    calcularImpuestos() {
      // Impuestos sobre el subtotal menos descuentos
      const baseImponible = this.calcularSubtotal() - this.calcularDescuentos();
      return baseImponible * (this.pedido.impuestos / 100);
    },
    calcularTotal() {
      // Subtotal - descuentos + impuestos + envío
      return (
        this.calcularSubtotal() -
        this.calcularDescuentos() +
        this.calcularImpuestos() +
        this.pedido.costoEnvio
      );
    },
    seleccionarProducto(producto) {
      if (producto) {
        this.nuevoProducto.nombre = producto.nombre;
        this.nuevoProducto.imagen = producto.imagen;
        this.nuevoProducto.precio = producto.precio;
        this.calcularPrecioFinalNuevo();
      }
    },
    calcularPrecioFinalNuevo() {
      const cantidad = parseInt(this.nuevoProducto.cantidad) || 1;
      const precio = parseFloat(this.nuevoProducto.precio) || 0;
      const descuento = parseFloat(this.nuevoProducto.descuento) || 0;

      const precioTotal = precio * cantidad;
      const descuentoTotal = precioTotal * (descuento / 100);

      this.nuevoProducto.precioFinal = (precioTotal - descuentoTotal).toFixed(2);
    },
    agregarProducto() {
      // Verificar si el producto ya existe en el pedido
      const productoExistente = this.pedido.productos.find(p => p.id === this.nuevoProducto.id.id);

      if (productoExistente) {
        // Actualizar cantidad y precio final
        productoExistente.cantidad += parseInt(this.nuevoProducto.cantidad);
        this.calcularPrecioFinalProducto(productoExistente);
      } else {
        // Agregar nuevo producto
        this.pedido.productos.push({
          id: this.nuevoProducto.id.id,
          nombre: this.nuevoProducto.nombre,
          imagen: this.nuevoProducto.imagen,
          cantidad: parseInt(this.nuevoProducto.cantidad),
          precio: parseFloat(this.nuevoProducto.precio),
          descuento: parseFloat(this.nuevoProducto.descuento),
          precioFinal: parseFloat(this.nuevoProducto.precioFinal)
        });
      }

      // Reiniciar formulario y cerrar diálogo
      this.nuevoProducto = {
        id: null,
        nombre: '',
        imagen: '',
        cantidad: 1,
        precio: 0,
        descuento: 0,
        precioFinal: 0
      };
      this.mostrarDialogoAgregarProducto = false;
    },
    calcularPrecioFinalProducto(producto) {
      const precioTotal = producto.precio * producto.cantidad;
      const descuentoTotal = precioTotal * (producto.descuento / 100);
      producto.precioFinal = (precioTotal - descuentoTotal).toFixed(2);
    },
    confirmarEliminarProducto(producto) {
      this.productoAEliminar = producto;
      this.mostrarDialogoEliminarProducto = true;
    },
    eliminarProducto() {
      if (this.productoAEliminar) {
        const index = this.pedido.productos.findIndex(p => p.id === this.productoAEliminar.id);
        if (index !== -1) {
          this.pedido.productos.splice(index, 1);
        }
      }
      this.mostrarDialogoEliminarProducto = false;
      this.productoAEliminar = null;
    },
    confirmarEliminarPedido() {
      this.mostrarDialogoEliminarPedido = true;
    },
    eliminarPedido() {
      // Aquí iría la lógica para eliminar el pedido
      alert('Pedido eliminado correctamente');
      this.mostrarDialogoEliminarPedido = false;
      this.volver();
    },
    abrirVentanaPago() {
      this.mostrarDialogoPago = true;
    },
    procesarPago() {
      // Aquí iría la lógica para procesar el pago según el método seleccionado
      alert(`Pago procesado correctamente mediante ${this.metodoPagoSeleccionado}`);
      this.mostrarDialogoPago = false;
    },
    volver() {
      // Aquí iría la lógica para volver a la lista de pedidos
      alert('Volviendo a la lista de pedidos');
    }
  }
}
</script>

<style scoped>
.v-data-table :deep(th) {
  background-color: #f5f5f5 !important;
  font-weight: bold !important;
}
</style>