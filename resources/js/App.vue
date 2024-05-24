<template>
    <v-app>
        <v-app-bar :elevation="2">
  <template v-slot:prepend>
    <v-app-bar-nav-icon></v-app-bar-nav-icon>
  </template>

  <v-app-bar-title>Applicaciones Creativas</v-app-bar-title>
</v-app-bar>
        <v-main>
            <router-view>
        
            </router-view>
        </v-main>
    </v-app>
</template>