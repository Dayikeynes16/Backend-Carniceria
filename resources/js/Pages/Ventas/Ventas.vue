<template>
  <v-container>
    <overlay :activo="cargando"></overlay>

    <v-row>
      <v-col cols="12">
        <h1 class="text-h4 font-weight-bold mb-2">Listado de Pedidos</h1>
        <p class="text-subtitle-1 text-medium-emphasis mb-6">
          Pedidos activos y pendientes
        </p>
      </v-col>
    </v-row>

    <v-row class="mb-6">
      <v-col cols="12" md="6">
        <v-tabs
          v-model="filtroActivo"
          background-color="primary"
          dark
          centered
          grow
        >
          <v-tab value="todos">Todos</v-tab>
          <v-tab value="activo">Activos</v-tab>
          <v-tab value="en proceso">Pendientes</v-tab>
        </v-tabs>
      </v-col>
      <v-col cols="12" md="6" class="d-flex align-center">
        <v-text-field
          v-model="busqueda"
          prepend-inner-icon="mdi-magnify"
          label="Buscar pedidos..."
          single-line
          hide-details
          variant="outlined"
          density="compact"
          class="mr-2"
        ></v-text-field>
        <v-menu>
          <template v-slot:activator="{ props }">
            <v-btn
              icon
              variant="outlined"
              v-bind="props"
            >
              <v-icon>mdi-filter-variant</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item
              v-for="(item, index) in opcionesFiltro"
              :key="index"
              :value="item"
              @click="ordenarPor(item.valor)"
            >
              <v-list-item-title>{{ item.texto }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-col>
    </v-row>

    <v-row v-if="pedidosOrdenados.length > 0">
      <v-col
        v-for="pedido in pedidosOrdenados"
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
                <span class="font-weight-medium">Pedido: #{{ pedido.id }}</span>
              </div>
              <v-chip
                :color="pedido.estatus === 'activo' ? 'primary' : 'grey'"
                :text-color="pedido.estatus === 'activo' ? 'white' : ''"
                size="small"
              >
                <v-icon size="x-small" start>
                  {{ pedido.estatus === 'activo' ? 'mdi-check-circle' : 'mdi-clock-outline' }}
                </v-icon>
                {{ pedido.estatus === 'activo' ? 'Activo' : 'Pendiente' }}
              </v-chip>
            </div>
          </v-card-item>
          <v-divider></v-divider>
          <v-card-text>
            <div class="mb-3">
              <div class="font-weight-bold">{{ pedido.cliente_id ? pedido.cliente_id : "Desconocido" }}</div>
              <div class="text-body-2 text-medium-emphasis">Metodo de pago: {{ pedido.metodo_de_pago }}</div>
            </div>
            <v-row>
              <v-col cols="6">
                <div class="text-caption text-medium-emphasis">Fecha</div>
                <div>{{ pedido.created_at.split('T')[0] }}</div>
              </v-col>
              <v-col cols="6">
                <div class="text-caption text-medium-emphasis">Productos</div>
                <div>{{ pedido.productos?.length || 0}}</div>
              </v-col>
              <v-col cols="12">
                <div class="text-caption text-medium-emphasis">Total</div>
                <div class="text-h6 font-weight-bold">${{ pedido.total }}</div>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn
              variant="outlined"
              block
              color="primary"
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
        <h3 class="text-h5 font-weight-bold">No se encontraron pedidos</h3>
        <p class="text-medium-emphasis">
          No hay pedidos que coincidan con los criterios de búsqueda actuales.
        </p>
      </v-col>
    </v-row>
  </v-container>
</template>

<script src="./ventas.js"></script>

<style scoped>
.h-100 {
  height: 100%;
}
</style>