<template>

    <v-container>
        <v-row>
            <v-col cols="4">

                <v-card>
                    <v-card-title>
                        Hola
                    </v-card-title>
                    <v-card-text>
                        <el-upload class="upload-demo" drag :http-request="cotizar" ref='loadform'
                            :data="{ 'material': 1 }" accept=".stl" :headers="{
                                'X-CSRF-TOKEN': token
                            }" :auto-upload="true">
                            <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                            <div class="el-upload__text">
                                Drop file here or <em>click to upload</em>
                            </div>
                            <template #tip>
                                <div class="el-upload__tip">
                                    jpg/png files with a size less than 500kb
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
                        el volumen final es de {{ volumen }}


                    </v-card-text>
                    <v-card-actions>

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

const resultado = ref (false)
const volumen = ref(''); 

const loading = ref(false)
const cotizar = async (file) => {

    loading.value = true
    resultado.value = false

    const { data } = await axios.post('/calculate', {
        file: file.file
    }, {
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'multipart/form-data'
        }
    })

    loading.value = false
    console.log(data.result_data.final_volume);
    volumen.value = data.result_data.final_volume
    resultado.value = true

    



}



</script>