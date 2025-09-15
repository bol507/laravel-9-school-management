import CustomScrollBar from './custom-scroll-bar';

const Selector = {
    sidebar: '.sidebar',
    mainSidebar: '.main-sidebar'
};

function scrollSidebar() {
    const sideBar = document.querySelector(Selector.sidebar);
    if (!sideBar) return;

    const mainSidebar = document.querySelector(Selector.mainSidebar);
    if (!mainSidebar) return;

    const header = document.querySelector('.main-header');
    const headerHeight = header ? header.offsetHeight : 0;

    const availableHeight = window.innerHeight - headerHeight;
  
    const scroll = new CustomScrollBar(Selector.mainSidebar, Selector.sidebar, {
        maxHeight     : availableHeight+'px',
        scrollerColor : '#ff6600',
        scrollerWidth : 6,
        scrollerRadius: 3
    });
}

document.addEventListener('DOMContentLoaded', () => {
    scrollSidebar();
});