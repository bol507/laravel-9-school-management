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
import leave from './components/leave';

// global store for theme
import themeStore from './components/theme-switcher';

window.Alpine = Alpine;

Alpine.plugin(focus);
//x-data
Alpine.data('salaryIncrease', salaryIncrease);
Alpine.data('sidebarState', sidebarState);
Alpine.data('employee', employee);
Alpine.data('leave', leave)
// accesible  $store.theme
Alpine.store('theme', themeStore);
Alpine.start();
