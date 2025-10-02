export default function sidebarState() {
    return {
        sidebarOpen: true,
        init() {
            const saved = localStorage.getItem('sidebarOpen');
            this.sidebarOpen = saved !== 'false';
        },
        toggle() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarOpen', this.sidebarOpen);
        }
    };
}