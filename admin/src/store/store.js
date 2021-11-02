import Vue from "vue";
import Vuex from "vuex";
import { mutations } from "./mutations";
import { actions } from "./actions";

Vue.use(Vuex);

// Globalización
export const store = new Vuex.Store({
    state: {
        /**
         * Backend API
         */
        api: "http://localhost/samourt/public/api/",
        /**
         * Sidebar responsive
         */
        sidebarShow: 'responsive',
        /**
         * Minimizar sidebar
         */
        sidebarMinimize: false,

        /**
         * Estado inicial de sesión
         */
        status: "",

        /**
         * Token con informaciónd e sesión del usuario
         */
        token: localStorage.getItem("token") || null,

        /**
         * Información del usuario
         */
        user: {},
    },
    mutations,
    actions,
    getters: {
        isLoggedIn: (state) => state.token != null,
        user: (state) => state.user,
        api: (state) => state.api,
        token: (state) => state.token,
     },
});