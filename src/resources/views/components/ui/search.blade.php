@props(['action', 'search' => '' ])


<form method="GET" action="{{ $action }}" id="searchForm">
  <div class="flex items-center py-2">
    <span class="mr-2">
      Search:
    </span>
    <input
      type="text"
      name="search"
      class="form-control form-control-sm"
      id="searchInput"
      value="{{old('search', $search) }}">

  </div>
</form>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('searchInput');
  let timer;

  input.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {

      const url = new URL('{{ $action }}', location.origin);
      url.search = new URLSearchParams(new FormData(input.form)).toString();
      location.href = url.toString();
    }, 1000);
  });
});
</script>
