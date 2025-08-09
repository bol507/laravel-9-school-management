<div class="col-sm-12 col-md-6">
  <form method="GET" action="{{ route('student.class.view') }}">
    <div class="d-flex align-items-center float-left py-2">
      <span class="mr-2">
        Show
      </span>
      <select
        name="limit"
        aria-controls="table"
        class="form-control form-control-sm"
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
</div>