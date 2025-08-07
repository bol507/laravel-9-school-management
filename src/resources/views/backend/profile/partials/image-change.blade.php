<script>
  document.addEventListener('DOMContentLoaded', function() {
    const image = document.getElementById('image');
    image.addEventListener('change', function() {
      const reader = new FileReader();
      reader.onload = function(e) {
        const image = document.getElementById('show-image');
        image.src = e.target.result;
      };
      reader.readAsDataURL(image.files[0]);
    });
  });
</script>