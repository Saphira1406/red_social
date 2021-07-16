import {
    apiFetch
} from "../functions/fetch.js";

let userData = {
    id: null,
    usuario: null,
    email: null,
    imagen: null,
    nombre: null,
    apellido: null,
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
        return apiFetch('/iniciar-sesion', {
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
                        imagen: response.data.imagen,
                        nombre: response.data.nombre,
                        apellido: response.data.apellido,
                        email
                    };
                    // Guardamos en localStorage el estado del usuario.
                    localStorage.setItem('userData', JSON.stringify(userData));
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
        return apiFetch('/cerrar-sesion', {
            method: 'POST',
        }).then(res => {
            if (res.success) {
                userData = {
                    id: null,
                    usuario: null,
                    email: null,
                    imagen: null,
                    nombre: null,
                    apellido: null,
                };
                localStorage.removeItem('userData');
                return true;
            }
        });
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

// Leemos localStorage para ver si el usuario está autenticado o no.
if (localStorage.getItem('userData') !== null) {
    userData = JSON.parse(localStorage.getItem('userData'));
}

export default authService;