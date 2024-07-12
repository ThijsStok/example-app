function previewImage() {
    var preview = document.getElementById('imagePreview');
    var file    = document.getElementById('image').files[0];
    var reader  = new FileReader();
    
    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        preview.style.display = 'none';
    }
}