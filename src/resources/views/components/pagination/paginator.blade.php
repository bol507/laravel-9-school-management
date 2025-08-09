@if ($docs->lastPage() > 1)
<div class="col-sm-12 col-md-7">
    <div class="dataTables_paginate paging_simple_numbers float-right" id="paginate">
        <ul class="pagination">
            <li class="paginate_button page-item previous {{ $docs->currentPage() == 1 ? ' disabled' : '' }}" id="previous">
                @if ($docs->currentPage() == 1)
                <span class="page-link" aria-controls="table" aria-disabled="true" tabindex="-1" role="button">
                @else
                <a href="{{ $docs->previousPageUrl() }}" aria-controls="table" class="page-link" role="button" rel="prev">
                @endif
                    Previous
                @if ($docs->currentPage() == 1)</span>@else</a>@endif
            </li>
            @php
                $currentPage = $docs->currentPage();
                $lastPage = $docs->lastPage();
                $start = max(1, $currentPage - 2);  
                $end = min($lastPage, $currentPage + 2);  
            @endphp

            @if ($start > 1)
                <li class="paginate_button page-item">
                    <a href="{{ $docs->url(1) }}" class="page-link">1</a>
                </li>
                @if ($start > 2)
                    <li class="paginate_button page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                <li class="paginate_button page-item {{ ($currentPage == $i) ? ' active' : '' }}">
                    <a href="{{ $docs->url($i) }}" class="page-link">{{ $i }}</a>
                </li>
            @endfor

            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <li class="paginate_button page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="paginate_button page-item">
                    <a href="{{ $docs->url($lastPage) }}" class="page-link">{{ $lastPage }}</a>
                </li>
            @endif
            <li class="paginate_button page-item next {{ $docs->currentPage() == $docs->lastPage() ? ' disabled' : '' }}" id="next">
                @if ($docs->currentPage() == $docs->lastPage())
                <span class="page-link" aria-controls="table" aria-disabled="true" tabindex="-1" role="button">
                @else
                <a href="{{ $docs->nextPageUrl() }}" aria-controls="table" class="page-link" role="button" rel="next">
                @endif
                    Next
                @if ($docs->currentPage() == $docs->lastPage())</span>@else</a>@endif
            </li>
        </ul>
    </div>
</div>
@endif