<div 
    id="pagination_info" 
    class="dataTables_info"
    role="status" 
    aria-live="polite"
>
    <template x-if="pagination && pagination.total > 0">
        <span x-text="`Showing ${pagination.from} - ${pagination.to} of ${pagination.total}`"></span>
    </template>
    <template x-if="!pagination || pagination.total === 0">
        <span>Showing 0 - 0 of 0</span>
    </template>
</div>