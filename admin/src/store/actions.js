//import { router } from "../main";
import axios from "axios";

export const actions = {
    /**
     * Inicia sesión y sincroniza con el backend
     *
     * @param {*} param0
     * @param {*} formData
     */
     login({ commit, state }, formData) {
        return new Promise((resolve, reject) => {
            axios
            .post(state.api + "login", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
            .then((resp) => {
              
                const data = resp.data;
                if (data.success) {
                    const token = data.body.access_token;
                    localStorage.setItem("token", token);
                    axios.defaults.headers.common["Accept"] = 'application/json';
                    axios.defaults.headers.common["Authorization"] = 'Bearer '+ token;
                    
                    resolve(resp.data);
                } else {
                    throw data.error;
                }
            })
            .catch((err) => {
                commit("auth_error");
                localStorage.removeItem("token");
                reject(err);
            });
        });
    },

    /**
     * Obtiene el usuario conectado
     *
     * @param {*} param0
     * @param {*} formData
     */
    owner({ commit, state }) {
        return new Promise((resolve, reject) => {
            axios
            .get(state.api + "user")
            .then((resp) => {
                const data = resp.data;
                resolve(data);
            })
            .catch((err) => {
                reject(err);
            });
        });
    },

    /**
     * Cieerra la sesión de un usuario
     *
     * @param {*} param0
     * @param {*} formData
     */
    logout({ commit, state }) {
        return new Promise((resolve, reject) => {
            axios
            .post(state.api + "logout")
            .then((resp) => { 
                commit("logout");
                resolve(resp) 
            })
            .catch((err) => { reject(err) });
        });
    }
};
