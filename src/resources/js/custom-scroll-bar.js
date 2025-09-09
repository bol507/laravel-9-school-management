class CustomScrollBar {
    constructor(containerMain, containerSelector,  options = {}) {
        const defaults = {
            width: "auto",
            height: "250px",
            size: "7px",
            color: "#000",
            position: "right",
            distance: "1px",
            start: "top",
            opacity: 0.4,
            alwaysVisible: false,
            disableFadeOut: false,
            railVisible: false,
            railColor: "#333",
            railOpacity: 0.2,
            railDraggable: true,
            borderRadius: "7px",
            railBorderRadius: "7px",
            wheelStep: 20,
            touchScrollStep: 200,
        };  
        this.options = Object.assign({}, defaults, options);
        this.scrollContainer = document.querySelector(containerMain);
        this.scrollContentWrapper = null;
        this.scrollContent = this.scrollContainer.querySelector(containerSelector);
        this.contentPosition = 0;
        this.scrollerBeingDragged = false;
        this.scroller = null;
        this.topPosition = 0;
        this.scrollerHeight = 0;
        this.normalizedPosition = 0;

        this.createContentWrapper();
        this.createScroller();
        this.applyCustomStyles(); 
        this.addEventListeners();
    }

    applyCustomStyles() {
        if (this.options.maxHeight) {
            this.scrollContainer.style.maxHeight = this.options.maxHeight;
        }
        if (this.scrollContentWrapper) {
            this.scrollContentWrapper.style.paddingRight = `${this.options.paddingRight}px`;
        }
    }

    createContentWrapper() {
        this.scrollContentWrapper = this.scrollContainer.querySelector('.slimScroll');

        if (!this.scrollContentWrapper && this.scrollContent) {
            this.scrollContentWrapper = document.createElement('div');
            this.scrollContentWrapper.className = 'slimScroll';
            this.scrollContent.parentNode?.insertBefore(this.scrollContentWrapper, this.scrollContent);
            this.scrollContentWrapper.appendChild(this.scrollContent);
        }
    }
    calculateScrollerHeight() {
        const visibleRatio = this.scrollContainer.offsetHeight / this.scrollContentWrapper.scrollHeight;
        return visibleRatio * this.scrollContainer.offsetHeight;
    }

    moveScroller() {
        const scrollPercentage = this.scrollContentWrapper.scrollTop / (this.scrollContentWrapper.scrollHeight - this.scrollContainer.offsetHeight);
        this.topPosition = scrollPercentage * (this.scrollContainer.offsetHeight - this.scrollerHeight);
        this.scroller.style.top = this.topPosition + 'px';
    }

    startDrag(evt) {
        this.normalizedPosition = evt.pageY;
        this.contentPosition = this.scrollContentWrapper.scrollTop;
        this.scrollerBeingDragged = true;
        document.body.style.cursor = 'grabbing';
        evt.preventDefault();
    }

    stopDrag() {
        this.scrollerBeingDragged = false;
        document.body.style.cursor = 'default';
    }

    scrollBarScroll(evt) {
        if (this.scrollerBeingDragged) {
            const mouseDifferential = evt.pageY - this.normalizedPosition;
            const scrollRatio = this.scrollContentWrapper.scrollHeight / (this.scrollContainer.offsetHeight - this.scrollerHeight);
            const scrollEquivalent = mouseDifferential * scrollRatio;
            this.scrollContentWrapper.scrollTop = this.contentPosition + scrollEquivalent;
        }
    }

    createScroller() {
        this.scroller = document.createElement("div");
        this.scroller.className = 'scroller';
        this.scrollerHeight = this.calculateScrollerHeight();

        if (this.scrollerHeight < this.scrollContainer.offsetHeight) {
             Object.assign(this.scroller.style, {
                width           : `${this.options.scrollerWidth}px`,
                backgroundColor : this.options.scrollerColor,
                borderRadius    : `${this.options.scrollerRadius}px`
            }); 
            this.scrollContainer.appendChild(this.scroller);
            this.scrollContainer.classList.add('showScroll');
        }
    }

    addEventListeners() {
        this.scrollContentWrapper.addEventListener('scroll', () => this.moveScroller());
        this.scroller?.addEventListener('mousedown', (evt) => this.startDrag(evt));
        window.addEventListener('mouseup', () => this.stopDrag());
        window.addEventListener('mousemove', (evt) => this.scrollBarScroll(evt));
    }
}

export default CustomScrollBar;