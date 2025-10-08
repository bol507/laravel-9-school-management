/**
 * Creates a reusable Alpine.js component for handling pagination state and logic.
 *
 * This component manages current page, total items, and generates a smart page range
 * for rendering pagination controls (e.g., "1 2 ... 5 6 7 ... 10 11").
 *
 * @param {number} customPerPage - Default number of items per page (default: 10).
 * @returns {Object} Alpine.js-compatible reactive object with pagination state and methods.
 */
export default function paginationComponent(customPerPage = 10) {
    return {
        // === Reactive state ===
        currentPage: 1,      // Current page number
        lastPage: 1,         // Total number of pages
        total: 0,            // Total number of items across all pages
        from: 0,             // First item number on current page (e.g., 1)
        to: 0,               // Last item number on current page (e.g., 10)
        perPage: customPerPage, // Items per page

        /**
         * Initialize pagination state from backend response data.
         * Typically called after an API fetch.
         *
         * @param {Object} paginationData - Object containing pagination metadata
         *                                  (e.g., { current_page: 1, last_page: 5, total: 48, from: 1, to: 10 })
         */
        initPagination(paginationData) {
            this.currentPage = paginationData.current_page;
            this.lastPage = paginationData.last_page;
            this.total = paginationData.total;
            this.from = paginationData.from;
            this.to = paginationData.to;
        },

        /**
         * Navigate to a specific page number.
         * Prevents invalid navigation (out of bounds or same page).
         *
         * @param {number} page - Target page number
         */
        setPage(page) {
            if (page < 1 || page > this.lastPage || page === this.currentPage) return;
            this.currentPage = page;
        },

        /**
         * Generate an array of page numbers to display in the pagination control.
         * Uses a "sliding window" algorithm to show a limited set of pages (e.g., 5 at a time),
         * centered around the current page when possible.
         *
         * @returns {number[]} Array of page numbers to render (e.g., [3, 4, 5, 6, 7])
         */
        renderPaginationLinks() {
            const pages = [];
            const maxVisible = 5; // Maximum number of page links to show
            let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
            let end = Math.min(this.lastPage, start + maxVisible - 1);
            start = Math.max(1, end - maxVisible + 1);

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }

            return pages;
        }
    };
}
