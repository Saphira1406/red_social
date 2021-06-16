// Services es como solemos llamar a archivo que exportar alguna funcionalidad para que el resto del
// sistema (ej: componentes) puedan utilizar.
import {
    apiFetch
} from "../functions/fetch.js";

let userData = {
    id: null,
    usuario: null,
    email: null,
};

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const authService = {
    /**
     * Hace la petición de login al backend, y de tener éxito, marca al usuario como autenticado.
     *
     * @param {string} email
     * @param {string} password
     * @return {Promise<*>}
     */
    login(email, password) {
        return apiFetch('/login.php', {
                method: 'POST',
                body: JSON.stringify({
                    email,
                    password,
                })
            })
            .then(response => {
                if (response.success) {
                    // Marcamos como autenticado al usuario, guardando la data en userData.
                    userData = {
                        id: response.data.id,
                        usuario: response.data.usuario,
                        email: response.data.email,
                    }
                }
                return response;
            });
    },

    /**
     *
     * @return {boolean}
     */
    isAuthenticated() {
        return userData.id !== null;
    },

    /**
     *
     */
    logout() {
        userData = {
            id: null,
            usuario: null,
            email: null,
        }
    },

    /**
     *
     * @return {{usuario: null, id: null, email: null}}
     */
    getUserData() {
        return {
            ...userData
        };
    },
};

export default authService;