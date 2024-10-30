<template>
    <v-container>
      <v-row>
        <v-col>
          <v-card variant="outlined" class="mt-0 pt-0">
            <v-card-title>
              <v-row>
                <v-col cols="4">
                  Clientes
                </v-col>
                <v-col cols="8"></v-col>
              </v-row>
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-row>
                    <v-col cols="8">
                      <v-text-field
                        v-model="search"
                        label="Buscar"
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                        hide-details
                        single-line
                      ></v-text-field>
                    </v-col>
                    <v-col cols="4">
                      <v-btn @click="addClient = true" block variant="outlined" style="height: 55px !important;">Nuevo</v-btn>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12">
                  <v-data-table
                    color="seconda"
                    variant="outlined"
                    :headers="headers"
                    :items="clientes"
                    :search="search"
                  >
                    <template v-slot:item.credito="{ item }">
                      <div v-if="item.credito">
                        Activo
                      </div>
                      <div v-else>
                        Inactivo
                      </div>
                    </template>
                    <template v-slot:item.acciones="{ item }">
                      <v-menu>
                        <template v-slot:activator="{ props }" align="center">
                          <div class="ms-6">
                            <v-icon
                              size="30"
                              color="primary"
                              icon="mdi-information-box-outline"
                              v-bind="props"
                            ></v-icon>
                          </div>
                        </template>
                        <v-list>
                          <v-list-item>
                            <v-btn block color="success" @click="router.push({name: 'detalle-cliente', params: { id: item.id }})" append-icon="mdi-account-search">
                              Más...
                            </v-btn>
                          </v-list-item>
                          <v-list-item>
                            <v-btn block color="blue" @click="editClient(item)" append-icon="mdi-pencil-outline">Editar</v-btn>
                          </v-list-item>
                          <!-- <v-list-item>
                            <v-btn block append-icon="mdi-delete-outline">Eliminar</v-btn>
                          </v-list-item> -->
                        </v-list>
                      </v-menu>
                    </template>
                  </v-data-table>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  
    <v-dialog v-model="addClient" max-width="500">
      <RegistroClientes
        :cliente="selectedClient"
        @cancelado="addClient = false"
        @agregado="handleClientAdded"
        @actualizado="handleClientUpdated"
      ></RegistroClientes>
    </v-dialog>

    <!-- <v-dialog v-model="showClientDialog">
      <DetallesCliente >

      </DetallesCliente>
    </v-dialog> -->
  </template>
  
  <script setup>

  import { useRouter } from "vue-router";
  import { ref, onMounted } from 'vue';
  import RegistroClientes from '../Components/RegistroClientes.vue';
  import DetallesCliente from './DetallesCliente.vue';
  import axios from '../axios';
  const router = useRouter();
  const showClientDialog = ref(false);
  const search = ref('');
  const addClient = ref(false);
  const selectedClient = ref({
    nombre: '',
    telefono: '',
    direccion: '',
    credito: false,
    monto: 0,
    update: false
  });
  const clientes = ref([]);
  const headers = ref([
    { title: 'Nombre', key: 'nombre' },
    { title: 'Teléfono', key: 'telefono' },
    { title: 'Estatus:', key: 'credito' },
    { title: 'Acciones', key: 'acciones' }
  ]);
  
  const getClients = () => {
    axios.get('/client-back')
      .then(({ data }) => {
        clientes.value = data.data;
      });
  };
  

  const handleClientAdded = () => {
    addClient.value = false;
    getClients();
  };
  
  const handleClientUpdated = () => {
    addClient.value = false;
    getClients();
  };
  
  const editClient = (client) => {
    selectedClient.value = { ...client, update: true };
    addClient.value = true;
  };

  const showClient = (client) => {
    showClientDialog.value = true
  }
  
  onMounted(() => {
    getClients();
  });
  </script>