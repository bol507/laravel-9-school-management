<template x-if="pagination && pagination.lastPage > 1">
    <div class="pagination-wrapper">

                <button class="paginate-button"
                        :disabled="pagination.currentPage === 1"
                        @click="goToPage(pagination.currentPage - 1)">
                    <svg class="h-4 w-4">
                        <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-left') }}"></use>
                    </svg>
                </button>


            <!-- First page -->

                <button class="paginate-button"  :class="{ active: pagination.currentPage === 1 }" @click="goToPage(1)">1</button>


            <!-- Left ellipsis -->
            <template x-if="pagination.currentPage > 3">

                    <span class="paginate-button  disabled">…</span>

            </template>

            <!-- Middle pages -->
            <template
                x-for="page in pagination.renderPaginationLinks().filter(p => p !== 1 && p !== pagination.lastPage)"
                :key="page"
            >

                    <button
                        class="paginate-button"
                        :class="{ active: pagination.currentPage === page }"
                        @click="goToPage(page)"
                        x-text="page"></button>

            </template>

            <!-- Right ellipsis -->
            <template x-if="pagination.currentPage < pagination.lastPage - 2">

                    <span class="paginate-button  disabled">…</span>

            </template>

            <!-- Last page -->

                <button
                    class="paginate-button"
                    :class="{ active: pagination.currentPage === pagination.lastPage }"
                    @click="goToPage(pagination.lastPage)"
                    x-text="pagination.lastPage"
                    x-show="pagination.lastPage > 1"></button>


            <!-- Next -->

                <button
                    class="paginate-button"
                    :class="{ disabled: pagination.currentPage === pagination.lastPage }"
                    :disabled="pagination.currentPage === pagination.lastPage"
                    @click="goToPage(pagination.currentPage + 1)">
                    <svg class="h-4 w-4">
                        <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-right') }}"></use>
                    </svg>
                </button>

    </div>
</template>
