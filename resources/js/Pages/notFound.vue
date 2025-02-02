<template>
    <v-container class="not-found">
        <el-header>
            <v-toolbar color="accent" dark>
                <v-toolbar-title>404 - Página No Encontrada</v-toolbar-title>
            </v-toolbar>
        </el-header>
        <el-main>
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" class="text-center">
                        <v-icon large color="error">mdi-alert-circle</v-icon>
                        <h1>404 - Página No Encontrada</h1>
                        <p>Lo sentimos, la ruta que has solicitado no existe.</p>
                        <router-link to="/">
                            <v-btn color="primary">Volver a la página principal</v-btn>
                        </router-link>
                    </v-col>
                </v-row>
            </v-container>
        </el-main>
    </v-container>
</template>

<script>

</script>
