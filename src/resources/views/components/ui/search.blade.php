
  <form method="GET" action="{{ $action }}" id="searchForm">
    <div class="flex items-center py-2">
      <span class="mr-2">
        Search:
      </span>
      <input 
        type="search" 
        name="search" 
        class="form-control form-control-sm"
        id="searchInput"
        value="{{$search ?? '' }}"
      >

    </div>
  </form>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    let debounceTimer = null;
    searchInput.addEventListener('input', function(){
      debounceTimer = setTimeout(function(){
        document.getElementById('searchForm').submit();
      }, 3000);
    })
  });
</script>