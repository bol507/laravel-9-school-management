<div class="col-sm-12 col-md-6">
  <form method="GET" action="{{ $action }}" id="searchForm">
    <div class="d-flex align-items-center float-right py-2">
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
</div>

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