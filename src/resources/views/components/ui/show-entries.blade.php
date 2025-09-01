@props([
    'action' => '',
    'docs' => null,
])


  <form method="GET" action="{{ $action }}">
    @foreach(request()->except('limit','page') as $key => $value)
      <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <div class="flex items-center py-2">
      <span class="mr-2">
        Show
      </span>
      <select
        name="limit"
        aria-controls="table"
        class="form-select appearence-none"
        onchange="this.form.submit()"
      >
        <option value="10" @if( $docs->perPage() == '10' ) selected @endif>10</option>
        <option value="25" @if( $docs->perPage() == '25' ) selected @endif>25</option>
        <option value="50" @if( $docs->perPage() == '50' ) selected @endif>50</option>
        <option value="100" @if( $docs->perPage() == '100' ) selected @endif>100</option>
      </select>
      <span class="ml-2">
        entries
      </span>
    </div>
  </form>
