<template >
 

 <v-card
      class="mx-auto pa-12 pb-8"
      elevation="8"
      max-width="448"
      rounded="lg"
    >
    <v-form  @submit.prevent="registrar()">
    
      <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
      

        <v-text-field
      v-model="form.name"
        density="compact"
        placeholder="Ingresa tu nombre"
        
        variant="outlined"
      ></v-text-field>
      <div class="text-subtitle-1 text-medium-emphasis">Correo</div>
      
      <v-text-field
      v-model="form.email"
        density="compact"
        placeholder="Correo electronico"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
      ></v-text-field>

      <div
        class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
      >
        Contraseña

        
      </div>

      <v-text-field
        v-model="form.password"
        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Ingresa una contraseña"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
      ></v-text-field>
      <div
        class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
      >
        Confirma tu contraseña

        
      </div>

      <v-text-field
        v-model="form.password_confirmation"
        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Re-ingresa tu contraseña"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
      ></v-text-field>

      <v-btn type="submit" class="mb-8" color="blue" size="large" variant="tonal" block>
        Registrarse
      </v-btn>
      </v-form>

      <v-card-text class="text-center">
        <a
          class="text-blue text-decoration-none"
          @click ='router.push({name:"logear"})'
          rel="noopener noreferrer"
          target="_blank"
        >
          ¿Ya tienes una cuenta? Ingresa <v-icon icon="mdi-chevron-right"></v-icon>
        </a>
      </v-card-text>
    </v-card>



    <!-- <div id="body-content" style="position: relative;" >
        <div class="card" style="max-width: 70%; min-height: 67%;"   >
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <form id="formulario" @submit.prevent="registrar">
                    <div class="card-body">
                        <h1 class="card-title">Registrate</h1>
                        <label for="">Ingresa tu nombre </label>
                        <input v-model="form.name" type="text" class="form-control" :class="{'is-invalid': errorMessages.name}">
                        <div v-if="errorMessages.name" class="invalid-feedback">
                            <span v-for="error in errorMessages.name" :key="error">{{ error }}</span>
                        </div>
                        <label for="">Ingresa tu correo</label>
                        <input class="form-control" :class="{'is-invalid':errorMessages.email}" v-model="form.email" type="email">
                        <div v-if="errorMessages.email" class="invalid-feedback">
                            <span v-for="error in errorMessages.email"> {{ error }} </span>
                        </div>
                        <label for="">Ingresa una contraseña</label>
                        <input autocomplete="off" class="form-control" :class="{'is-invalid': errorMessages.password}" v-model="form.password" type="password">
                        <div v-if="errorMessages.password" class="invalid-feedback">
                            <span v-for="error in errorMessages.password"> {{ error }}</span>
                        </div>
                        <label  for="">Confirma tu contraseña</label>
                        <input class="form-control" :class="{'is-invalid':errorMessages.password_confirmation}" v-model="form.password_confirmation" type="password">
                            <span v-for="error in errorMessages.password_confirmation">{{ error }}</span> 
                            <p class="card-text"><small class="text-body-secondary">¿Ya tienes una cuenta? <router-link :to="{name:'logear'}">Inicia sesión</router-link></small></p>           
                    </div>
                        <button id="registrar" class="btn btn-primary" type="submit">Registrar</button>
                </form>
                
                </div>
                <div class="col-sm-6 d-sm-block d-none" style="min-height: 300px;">
                    <img   class="img-fluid rounded-start"  src="../../images/LoginImage.webp" alt="">
                </div>
                
            </div>
               
          
        
        </div>
       
    </div> -->
    
</template>

<script setup>

import { ref } from 'vue';
import  {useRouter} from 'vue-router'; 
const router = useRouter()

const errorMessages = ref({})

const visible = ref (false) 

const form = ref({
    name:null,
    email:null,
    password:null,
    password_confirmation: null
})

const registrar = async () => {
  try {
    const { data } = await axios.post('/usuarios', form.value);
    console.log(data);
    router.push({name:"cotizar"})

  } catch (error) {
    if (error.response.status   === 422) {
    console.log(error.response.data.errors);
    errorMessages.value = error.response.data.errors;
    } 
  }
};
</script>

<style>



#body-content{
    margin: 40px;
    
}
#registrar{
    justify-content: center;
    display: flex;
    margin: 10px;
}
</style>