export default function paginationComponent(customPerPage = 10) {
    return {
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        perPage: customPerPage,

        initPagination(paginationData) {
            this.currentPage = paginationData.current_page;
            this.lastPage = paginationData.last_page;
            this.total = paginationData.total;
            this.from = paginationData.from;
            this.to = paginationData.to;
        },

         setPage(page) {
            if (page < 1 || page > this.lastPage || page === this.currentPage) return;
            this.currentPage = page;
        },

        renderPaginationLinks() {
            const pages = [];
            const maxVisible = 5;
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