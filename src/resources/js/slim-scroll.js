/*  slimScroll vanilla – API compatible con el plugin jQuery
    (solo dependencias: ES5 + CSS variables)
    Uso:
        document.querySelector('.sidebar').slimScroll({height:'300px',color:'#666'});
        document.querySelector('.sidebar').slimScroll({destroy:true});
*/
(function () {
  /* ---------- Helper functions ---------- */
  const css = (el, styles) => {
    Object.keys(styles).forEach(key => el.style[key] = styles[key]);
  };

  const on = (el, event, handler) => {
    el.addEventListener(event, handler, false);
  };

  const off = (el, event, handler) => {
    el.removeEventListener(event, handler, false);
  };

  const trigger = (el, name, detail) => {
    el.dispatchEvent(new CustomEvent(name, { detail }));
  };

  /* ---------- Default options ---------- */
  const defaultOptions = {
    width: 'auto',
    height: '250px',
    size: '7px',
    color: '#000',
    position: 'right',
    distance: '1px',
    start: 'top',
    opacity: 0.4,
    alwaysVisible: false,
    railVisible: false,
    railColor: '#333',
    railOpacity: 0.2,
    railDraggable: true,
    wrapperClass: 'slimScrollDiv',
    railClass: 'slimScrollRail',
    barClass: 'slimScrollBar',
    wheelStep: 20,
    touchScrollStep: 200,
    borderRadius: '7px',
    railBorderRadius: '7px',
  };

  /* ---------- SlimScroll constructor ---------- */
  function SlimScroll(element, options) {
    if (element._ss) element._ss.destroy(); // Prevent duplicates
    element._ss = this;
    this.target = element;
    this.opts = Object.assign({}, defaultOptions, options);
    this.init();
  }

  SlimScroll.prototype = {
    init() {
      const { target, opts } = this;
      target.style.overflow = 'hidden';

      // Create wrapper, rail, and bar
      this.wrap = this.createElement('div', opts.wrapperClass, {
        position: 'relative',
        overflow: 'hidden',
        width: opts.width,
        height: opts.height,
      });

      this.rail = this.createElement('div', opts.railClass, {
        top: 0,
        width: opts.size,
        height: '100%',
        position: 'absolute',
        background: opts.railColor,
        opacity: opts.railOpacity,
        zIndex: 90,
        borderRadius: opts.railBorderRadius,
        [opts.position]: opts.distance,
        display: opts.railVisible ? 'block' : 'none',
      });

      this.bar = this.createElement('div', opts.barClass, {
        top: 0,
        width: opts.size,
        position: 'absolute',
        background: opts.color,
        opacity: opts.opacity,
        borderRadius: opts.borderRadius,
        zIndex: 99,
        [opts.position]: opts.distance,
        display: opts.alwaysVisible ? 'block' : 'none',
      });

      // Assemble elements
      target.parentNode.insertBefore(this.wrap, target);
      this.wrap.appendChild(target);
      this.wrap.appendChild(this.rail);
      this.wrap.appendChild(this.bar);

      this.updateDimensions();
      this.bindEvents();

      if (opts.start === 'bottom') this.scrollTo(target.scrollHeight);
      else if (opts.start !== 'top') this.scrollTo(parseInt(opts.start));
    },

    createElement(tag, className, styles) {
      const element = document.createElement(tag);
      element.className = className;
      css(element, styles);
      return element;
    },

    updateDimensions() {
      const { target, wrap, bar } = this;
      this.contentHeight = target.scrollHeight;
      this.visibleHeight = wrap.clientHeight;
      this.ratio = this.visibleHeight / this.contentHeight;
      this.barHeight = Math.max(this.ratio * this.visibleHeight, 30);
      css(bar, { height: `${this.barHeight}px` });
    },

    bindEvents() {
      const { bar, wrap, target } = this;

      // Wheel event
      on(wrap, 'wheel', (e) => {
        this.scrollBy(e.deltaY < 0 ? -this.opts.wheelStep : this.opts.wheelStep);
        e.preventDefault();
      });

      // Dragging the bar
      let dragging = false;
      let startY, startTop;

      on(bar, 'mousedown', (e) => {
        dragging = true;
        startY = e.pageY;
        startTop = parseInt(bar.style.top) || 0;
        document.body.classList.add('ss-dragging');
        on(document, 'mousemove', this.onMouseMove.bind(this, startTop, startY));
        on(document, 'mouseup', this.onMouseUp.bind(this));
        e.preventDefault();
      });

      // Touch events
      on(target, 'touchstart', (e) => {
        this.touchY = e.targetTouches[0].pageY;
      });

      on(target, 'touchmove', (e) => {
        const dy = (this.touchY - e.targetTouches[0].pageY) / this.opts.touchScrollStep;
        this.scrollBy(dy * 100);
        this.touchY = e.targetTouches[0].pageY;
        e.preventDefault();
      });

      // Fade in/out
      if (!this.opts.alwaysVisible) {
        on(wrap, 'mouseenter', () => {
          bar.style.opacity = this.opts.opacity;
          if (this.opts.railVisible) this.rail.style.opacity = this.opts.railOpacity;
        });

        on(wrap, 'mouseleave', () => {
          setTimeout(() => {
            if (!this.opts.disableFadeOut) {
              bar.style.opacity = 0;
              this.rail.style.opacity = 0;
            }
          }, 1000);
        });
      }
    },

    onMouseMove(startTop, startY, e) {
      if (!dragging) return;
      const ny = startTop + (e.pageY - startY);
      this.barMove(ny);
    },

    onMouseUp() {
      dragging = false;
      document.body.classList.remove('ss-dragging');
      off(document, 'mousemove', this.onMouseMove);
      off(document, 'mouseup', this.onMouseUp);
    },

    barMove(top) {
      const max = this.visibleHeight - this.barHeight;
      top = Math.max(0, Math.min(top, max));
      this.bar.style.top = `${top}px`;
      const scrollTop = (top / max) * (this.contentHeight - this.visibleHeight);
      this.target.scrollTop = scrollTop;
      this.onScroll();
    },

    scrollBy(px) {
      this.scrollTo(this.target.scrollTop + px);
    },

    scrollTo(y) {
      const max = this.contentHeight - this.visibleHeight;
      y = Math.max(0, Math.min(y, max));
      this.target.scrollTop = y;
      const top = (y / max) * (this.visibleHeight - this.barHeight);
      this.bar.style.top = `${top}px`;
      this.onScroll();
    },

    onScroll() {
      const ratio = this.target.scrollTop / (this.contentHeight - this.visibleHeight);
      trigger(this.target, 'slimscrolling', ~~this.target.scrollTop);
      if (ratio <= 0) trigger(this.target, 'slimscroll', 'top');
      if (ratio >= 1) trigger(this.target, 'slimscroll', 'bottom');
    },

    update() {
      this.updateDimensions();
      this.onScroll();
    },

    destroy() {
      off(this.wrap, 'wheel', this._onWheel);
      off(document, 'mousemove', this.onMouseMove);
      off(document, 'mouseup', this.onMouseUp);
      off(this.bar, 'mousedown', this._onMD);
      off(this.target, 'touchstart', this._onTouchStart);
      off(this.target, 'touchmove', this._onTouchMove);
      this.wrap.parentNode.insertBefore(this.target, this.wrap);
      this.wrap.parentNode.removeChild(this.wrap);
      delete this.target._ss;
    }
  };

  /* ---------- Public API on HTMLElement ---------- */
  HTMLElement.prototype.slimScroll = function (opts) {
    if (opts === 'destroy' && this._ss) {
      this._ss.destroy();
      return;
    }
    if (opts === 'update' && this._ss) {
      this._ss.update();
      return;
    }
    if (typeof opts === 'number') {
      if (!this._ss) return;
      this._ss.scrollTo(opts);
      return;
    }
    new SlimScroll(this, opts);
    return this;
  };
})();