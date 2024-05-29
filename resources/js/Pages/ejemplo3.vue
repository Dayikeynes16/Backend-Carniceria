<template>

    <v-container>
        <v-row>
            <v-col cols="4">
                <v-card>
                    <v-card-title>
                        Sube tu archivo aqui
                    </v-card-title>
                    <v-card-text>
                        <el-upload class="upload-demo" drag :http-request="cotizar" ref='loadform'
                            :data="{ 'material': 1 }" accept=".stl" :headers="{
                                'X-CSRF-TOKEN': token
                            }" :auto-upload="true">
                            <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                            <div class="el-upload__text">
                                Arrastra tu archivo o <em>haz click para subir</em>
                            </div>
                            <template #tip>
                                <div class="el-upload__tip">
                                    Archivos STL de menos de 30 MB
                                </div>
                            </template>
                        </el-upload>

                       
                    </v-card-text>
                    
                </v-card>

                <v-overlay
                        :model-value="loading"
                        class="align-center justify-center"
                        >
                        <v-progress-circular
                            color="primary"
                            size="64"
                            indeterminate
                        ></v-progress-circular>
                </v-overlay>



            </v-col>
            <v-col cols="5">
                <v-card v-if="resultado" >
                    <v-card-title>
                        Resultado: 
                    </v-card-title>
                    <v-card-text>
                        El costo estimado es de: ${{ costo }} MXN
                        <br>
                        El tiempo de impresión estimado es de: {{ Math.round(tiempo_impresion) }} minutos
                        </v-card-text>
                    <v-card-actions>
                        <v-btn
                        @click = 'router.push({name: "cumpleaños"})'
                        >
                        
                            Proceder con la compra
                        </v-btn>
                    </v-card-actions>   
                </v-card>
            </v-col>
        </v-row>
    </v-container>


</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { UploadFilled } from '@element-plus/icons-vue'
const token = document.querySelector("meta[name='csrf-token']").getAttribute('value')
const loadform = ref()
const resultado = ref(false)
const volumen = ref(''); 
const costo = ref('');

const tiempo_impresion = ref('');
const loading = ref(false)
const errorMessage = ref('');
import  {useRouter} from 'vue-router'; 
const router = useRouter()

const cotizar = async (file) => {
    loading.value = true
    resultado.value = false
    errorMessage.value = ''
    try {
        const { data } = await axios.post('/calculate', {
            file: file.file
        }, {
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'multipart/form-data'
            }
        })
        loading.value = false    
        tiempo_impresion.value = ((data.result_data.print_time / 60)/3.46);
        costo.value = Math.round(tiempo_impresion.value * 1.5);
        resultado.value = true
    } catch (error) {
        loading.value = false
        if (error.response && error.response.data && error.response.data.message) {
            errorMessage.value = error.response.data.message
        } 
        console.error(errorMessage.value)
        alert(errorMessage.value)
    }
}
</script>

