/* ---------- CONFIG ---------- */
const Selector = {
    sidebar: '.sidebar',
    mainHeader: '.main-header'
};

/* ---------- Funciones auxiliares ---------- */
function initSlimScroll() {
    const list = [
        { selector: '.inner-content-div', height: 200 },
        { selector: '.sm-scrol', height: 250 },
        { selector: '.direct-chat-messages', height: 310 }
    ];
    list.forEach(({ selector, height }) => {
        const el = document.querySelector(selector);
        if (el) el.slimScroll({ height: `${height}px` });
    });
}

function initSearchToggle() {
    const searchBox = document.querySelector('.app-search');
    if (!searchBox) return;
    document.querySelectorAll('.search-box a, .search-box .app-search .srh-btn')
        .forEach(btn =>
            btn.addEventListener('click', () => {
                const show = searchBox.style.display === 'none';
                searchBox.style.display = show ? 'block' : 'none';
                searchBox.style.transition = 'opacity .2s';
                searchBox.style.opacity = show ? '0' : '1';
                setTimeout(() => searchBox.style.opacity = show ? '1' : '0', 0);
            })
        );
}

/* ---------- Ajuste del sidebar (layout fijo / no fijo) ---------- */
function fixSidebar() {
    const sideBar = document.querySelector(Selector.sidebar);
    if (!sideBar) return;

    const header = document.querySelector(Selector.mainHeader);

    const availableHeight = window.innerHeight - (header ? header.offsetHeight : 0);
  
    
    if (sideBar.slimScroll) sideBar.slimScroll({ destroy: true });
    sideBar.slimScroll({
        height: availableHeight + 'px', //availableHeight 'px',
        color: '#f00', //rgba(0,0,0,.)
        size: '5px',
        railVisible: true, 
        opacity: 0.7 
    });
}

/* ---------- Punto de entrada ---------- */
document.addEventListener('DOMContentLoaded', () => {
    initSlimScroll();
    initSearchToggle();
    fixSidebar();
});

window.addEventListener('resize', function() {
    fixSidebar();
});