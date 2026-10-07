import { createApp } from 'vue';
import axios from 'axios';
import App from './App.vue';

// Same-origin session auth: axios sends the XSRF cookie automatically.
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

createApp(App).mount('#app');
