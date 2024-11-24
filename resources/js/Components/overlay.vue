<template>
    <v-overlay 
    v-model="overlay"
      class="align-center justify-center"
      >
            <v-progress-circular
              color="blue"
              size="64"
              
              indeterminate
            ></v-progress-circular>
      </v-overlay>
</template>
<script setup>
import { ref } from 'vue';
const overlay = ref(true)
</script>