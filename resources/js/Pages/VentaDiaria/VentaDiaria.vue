<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <div class="d-flex justify-space-between align-center mb-6">
          <div>
            <h1 class="text-h4 font-weight-bold mb-2">Listado de Pedidos</h1>
            <p class="text-subtitle-1 text-medium-emphasis">
              Gestiona y visualiza todos tus pedidos.
            </p>
          </div>
          <v-card
            variant="outlined"
            color="primary"
            class="pa-4 text-center"
            width="220"
          >
            <p class="text-subtitle-2 mb-1">Total de Ventas</p>
            <p class="text-h5 font-weight-bold">{{ formatearPrecio(totalVentas) }}</p>
          </v-card>
        </div>
      </v-col>
    </v-row>

    <v-row v-if="pedidos.length > 0">
      <v-col
        v-for="pedido in pedidos"
        :key="pedido.id"
        cols="12"
        sm="6"
        lg="4"
      >
        <v-card variant="outlined" class="h-100">
          <v-card-item>
            <div class="d-flex justify-space-between align-center">
              <div class="d-flex align-center">
                <v-icon class="mr-2">mdi-package-variant</v-icon>
                <span class="font-weight-medium">{{ pedido.id }}</span>
              </div>
              <v-chip
                :color="pedido.estado === 'activo' ? 'primary' : 'grey'"
                :text-color="pedido.estado === 'activo' ? 'white' : ''"
                size="small"
              >
                <v-icon size="x-small" start>
                  {{ pedido.estado === 'activo' ? 'mdi-check-circle' : 'mdi-clock-outline' }}
                </v-icon>
                {{ pedido.estado === 'activo' ? 'Activo' : 'Pendiente' }}
              </v-chip>
            </div>
          </v-card-item>
          <v-divider></v-divider>
          <v-card-text>
            <div class="mb-3">
              <div class="font-weight-bold">{{ pedido.cliente }}</div>
              <div class="text-body-2 text-medium-emphasis">{{ pedido.direccion }}</div>
            </div>
            <v-row>
              <v-col cols="6">
                <div class="text-caption text-medium-emphasis">Fecha</div>
                <div>{{ pedido.fecha }}</div>
              </v-col>
              <v-col cols="6">
                <div class="text-caption text-medium-emphasis">Productos</div>
                <div>{{ pedido.productos }}</div>
              </v-col>
              <v-col cols="12">
                <div class="text-caption text-medium-emphasis">Total</div>
                <div class="text-h6 font-weight-bold">{{ pedido.total }}</div>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn
              variant="outlined"
              block
              color="primary"
              @click="verDetallesPedido(pedido.id)"
            >
              Ver detalles
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-row v-else>
      <v-col cols="12" class="text-center py-8">
        <v-icon size="large" color="grey" class="mb-4">mdi-alert-circle-outline</v-icon>
        <h3 class="text-h5 font-weight-bold">No hay pedidos disponibles</h3>
        <p class="text-medium-emphasis">
          No se encontraron pedidos en el sistema.
        </p>
      </v-col>
    </v-row>
  </v-container>
</template>

<script src="./VentaDiaria.js"></script>

<style scoped>
.h-100 {
  height: 100%;
}
</style>