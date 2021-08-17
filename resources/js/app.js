require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import OrdenComponent from  './components/OrdenComponent'

createApp({
    components: {
        OrdenComponent,
    }
}).mount('#app');
