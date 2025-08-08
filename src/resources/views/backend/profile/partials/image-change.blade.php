<script>
  document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('show-image');
    imageInput.addEventListener('change', function() {
      const file = imageInput.files[0];
      if(!file) return;
      //validate file type
      const fileType = file.type;
      if(!fileType.match(/image\/(png|jpg|jpeg)/)) {
        alert('Please select a valid image file.');
        return;
      }


      const reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.src = e.target.result;
      };
      reader.onerror = function() {
        alert('An error occurred while reading the file.');
      }
      reader.readAsDataURL(file);
    });
  });
</script>