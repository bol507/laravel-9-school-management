<template x-if="pagination && pagination.lastPage > 1">
    <div class="pagination-wrapper paging_simple_numbers float-right">
        <ul class="pagination">
            <!-- Previous -->
            <li class="paginate-button page-item previous"
                :class="{ disabled: pagination.currentPage === 1 }">
                <button class="page-link"
                        :disabled="pagination.currentPage === 1"
                        @click="goToPage(pagination.currentPage - 1)">
                    <svg class="h-4 w-4">
                        <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-left') }}"></use>
                    </svg>
                </button>
            </li>

            <!-- First page -->
            <li class="paginate-button page-item"
                :class="{ active: pagination.currentPage === 1 }">
                <button class="page-link" @click="goToPage(1)">1</button>
            </li>

            <!-- Left ellipsis -->
            <template x-if="pagination.currentPage > 3">
                <li class="paginate-button page-item disabled">
                    <span class="page-link">…</span>
                </li>
            </template>

            <!-- Middle pages -->
            <template x-for="page in pagination.renderPaginationLinks().filter(p => p !== 1 && p !== pagination.lastPage)"
                      :key="page">
                <li class="paginate-button page-item"
                    :class="{ active: pagination.currentPage === page }">
                    <button class="page-link" @click="goToPage(page)" x-text="page"></button>
                </li>
            </template>

            <!-- Right ellipsis -->
            <template x-if="pagination.currentPage < pagination.lastPage - 2">
                <li class="paginate-button page-item disabled">
                    <span class="page-link">…</span>
                </li>
            </template>

            <!-- Last page -->
            <li class="paginate-button page-item"
                :class="{ active: pagination.currentPage === pagination.lastPage }"
                x-show="pagination.lastPage > 1">
                <button class="page-link"
                        @click="goToPage(pagination.lastPage)"
                        x-text="pagination.lastPage"></button>
            </li>

            <!-- Next -->
            <li class="paginate-button page-item next"
                :class="{ disabled: pagination.currentPage === pagination.lastPage }">
                <button class="page-link"
                        :disabled="pagination.currentPage === pagination.lastPage"
                        @click="goToPage(pagination.currentPage + 1)">
                    <svg class="h-4 w-4">
                        <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-right') }}"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>
</template>