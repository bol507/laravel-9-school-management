import './bootstrap';
import './modal-confirm';
import './extra-item'; 
import './slim-sidebar';
import './upload-image';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
