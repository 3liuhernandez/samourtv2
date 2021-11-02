//import { router } from "../main";
//import axios from "axios";

export const mutations = {
	/**
     * Cambia el sidebar - Desktop
     * @param {*} state
     */
	toggleSidebarDesktop (state) {
	    const sidebarOpened = [true, 'responsive'].includes(state.sidebarShow)
	    state.sidebarShow = sidebarOpened ? false : 'responsive'
	},
	/**
     * Cambia el sidebar - Mobile
     * @param {*} state
     */
	toggleSidebarMobile (state) {
	    const sidebarClosed = [false, 'responsive'].includes(state.sidebarShow)
	    state.sidebarShow = sidebarClosed ? true : 'responsive'
	},
	/**
     * Cambia elvlaor deu na variable
     * @param {*} state
     */
	set (state, [variable, value]) {
	    state[variable] = value
	},

	/**
     * Estado de la solicitud de autorización, aprobado
     * @param {*} state
     * @param {*} user
     */
	auth_success(state, data) {
		state.status = "success";
		state.token = data.token;
		state.user = data.user;
	},
  
	/**
	 * Refresca los datos del usuario en sesión
	 * @param {*} state
	 * @param {*} user
	 */
	auth_refresh(state, user) {
		state.user = user;
	},
	
	/**
	 * Error de autenticación
	 *
	 * @param {*} state
	 */
	auth_error(state) {
		state.status = "error";
	},
	
	/**
	 * Limpia las variables de estado de sesión
	 *
	 * @param {*} state
	 */
	logout(state) {
		state.status = "";
		state.token = null;
	}
};
  