export default {
    current: 'dark',

    init() {
        this.current = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', this.current);
    },

    set(theme) {
        this.current = theme;
        localStorage.setItem('theme', theme);
        document.documentElement.setAttribute('data-theme', theme);
    }
};
