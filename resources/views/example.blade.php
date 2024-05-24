<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.5.10/dist/vuetify.min.css" rel="stylesheet">
   
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
 
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.5.10/dist/vuetify.min.js"></script>

    <title>testing</title>
</head>
<body>

    <div  id="app">
    <v-app>
    

    <v-container >
           
    <v-app-bar
        color="primary"
        density="compact"
        max-width="100%"
      >
        <v-app-bar-title> <h1 class=" font-weight-bold">STL counter</h1></v-app-bar-title>
        <template v-slot:append>
          <v-btn icon="mdi-dots-vertical"></v-btn>
        </template>
      </v-app-bar>
    
            <v-card 
                class="mx-auto"
                max-width="700"
                rounded="xl"
                variant="text"
                margin="20px"
                >
                
                    <p  class="text-center font-weight-bold "> spa sube tu archivo stl para calcular el costo</p>
                
                
                <v-sheet class="mx-auto" >
                    <v-form v-model="valid" :action="formAction" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <v-file-input label="File input" accept=".stl" id="file"  onchange="validateFile()" name="file"></v-file-input>
                            <v-btn type="submit">Subir Archivo</v-btn>
                    </v-form>
                </v-sheet>  
                
            </v-card>

            
            <v-footer>2014-Aplicaciones Creativas</v-footer>             
</v-container>

</v-app>    

</div>



<script>

new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data: {
                valid: true,
                file: null, 
                formAction: '{{ route("calculate") }}',
                csrfToken: '{{ csrf_token() }}'
            }, 
            methods: {
                validateFile() {
                    const allowedExtensions = /(\.stl)$/i;
                    if (!allowedExtensions.exec(this.file.name)) {
                        alert('Please upload file having extensions .stl only.');
                        this.file = null;
                        this.valid = false;
                    } else {
                        this.valid = true;
                    }
                },
                submitForm() {
                    if (this.valid && this.file) {
                        this.$refs.form.submit();
                    } else {
                        alert('Please upload a valid .stl file.');
                    }
                }

            }
        });
</script> 
</body>
</html>