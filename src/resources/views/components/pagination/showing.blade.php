
  <div class="col-sm-12 col-md-5">
   <div {{ $attributes->merge(['id' => 'pagination_info', 'class' => 'dataTables_info']) }} role="status" aria-live="polite">
      @if($docs->total())
        Showing {{ $docs->firstItem() }} to {{ $docs->lastItem() }} of {{ $docs->total() }} entries
      @else
        Showing 0 to 0 of 0 entries
      @endif
    </div>
  </div>
  
