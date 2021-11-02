import 'core-js/stable'
import Vue from 'vue'
import App from './App'
import router from './router'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import { store } from './store/store'
import axios from "axios";
import 'sweetalert2/dist/sweetalert2.min.css';
import VueSweetalert2 from 'vue-sweetalert2';

// SweetAlert 2
Vue.use(VueSweetalert2);

Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.prototype.$log = console.log.bind(console)

Vue.prototype.$http = axios;
// Token de sesión
const token = localStorage.getItem("token");
if (token) {
    Vue.prototype.$http.defaults.headers.common["Accept"] = 'application/json';
    Vue.prototype.$http.defaults.headers.common["Authorization"] = 'Bearer ' + token;
}


// Capturar las entradas
router.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.auth)) {
		if (store.getters.isLoggedIn) {
			next();
			return;
		}
		next("/login");

	}else if(to.matched.some(record => record.meta.guest)) {
		if(!store.getters.isLoggedIn) {
			next();
			return;
		}
		next("/");
	} else {
		next();
	}
});

new Vue({
    el: '#app',
    router,
    store,
    icons,
    template: '<App/>',
    components: {
        App
    }
})
