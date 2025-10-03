import './bootstrap';
import './modal-confirm';
import './extra-item';
import './slim-sidebar';
import './upload-image';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

import salaryIncrease from './components/salary-increase';
import sidebarState from './components/sidebar';
import employee from './components/employee';

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.data('salaryIncrease', salaryIncrease);
Alpine.data('sidebarState', sidebarState);
Alpine.data('employee', employee);
Alpine.start();
