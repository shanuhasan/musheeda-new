import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

Alpine.plugin(persist);
Alpine.plugin(collapse);

Alpine.start();
