<template>
    <v-card>
      <v-card-title>Lectura de Peso</v-card-title>
      <v-card-text>
        <div>{{ peso }}</div>
     
      </v-card-text>
    </v-card>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from 'vue';
  import { io } from 'socket.io-client';
  
  const peso = ref(null);
  let socket;
  
  onMounted(() => {
    // Reemplaza '192.168.0.229' con la dirección IP de tu servidor WebSocket
    socket = io('http://192.168.0.229:8765', {
      transports: ['websocket', 'polling']
    });
    
    socket.on('connect', () => {
      console.log('Conectado al servidor WebSocket');
    });
  
    socket.on('message', (data) => {
      peso.value = data;
    });
  
    socket.on('disconnect', () => {
      console.log('Desconectado del servidor WebSocket');
    });
  });
  
  onUnmounted(() => {
    if (socket) {
      socket.close();
    }
  });
  </script>
  
  <style scoped>
  /* Estilos personalizados */
  </style>