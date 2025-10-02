
    <div {{ $attributes->merge(['id' => 'pagination_info', 'class' => 'dataTables_info']) }} role="status" aria-live="polite">
        @if($docs->total())
        Showing {{ $docs->firstItem() }} - {{ $docs->lastItem() }} of {{ $docs->total() }}
        @else
        Showing 0 - 0 of 0
        @endif
    </div>
