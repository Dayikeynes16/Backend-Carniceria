<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testing</title>
</head>
<body>

<h2>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    you need to upload ur stl file to calculate the time printing and material ammount
</h2>
    
<form  action="{{ route('calculate') }}" method="post" enctype="multipart/form-data">
    @csrf
        <label for="file">Selecciona un archivo para subir:</label>
        @error('file')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
        <input type="file" accept=".stl" id="file"  onchange="validateFile()" name="file">
        <button type="submit">Subir Archivo</button>
    </form>


<script>
function validateFile() {
    const fileInput = document.getElementById('file');
    const filePath = fileInput.value;
    const allowedExtensions = /(\.stl)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Please upload file having extensions .stl only.');
        fileInput.value = ''; 
        return false;
    }
}
</script> 
</body>
</html>