import {
    apiFetch
} from "../functions/fetch.js";

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const usersService = {

    /**
     * Hace la petición para crear un usuario al backend y retorna la respuesta
     *
     * @param {{}} data
     * @return {Promise<*>}
     */
    create(data) {
        return apiFetch('/usuarios/nuevo', {
                method: 'POST',
                body: JSON.stringify(data)
            })
            .then(response => {
                return response;
            });
    },

    /**
     * Hace la petición de un usuario al backend por su id y retorna la respuesta
     *
     * @param {int} id
     * @return {Promise<*>}
     */
    fetch(id) {
        return apiFetch('/usuarios/' + id)
            .then(response => {
                return response;
            });
    },

    /**
     * Hace la petición de edición de un usuario al backend por su id y retorna la respuesta
     *
     * @param {int} id
     * @param {{}} data
     * @return {Promise<*>}
     */
    edit(id, data) {
        return apiFetch('/usuarios/' + id + '/editar', {
                method: 'PUT',
                body: JSON.stringify(data),
            })
            .then(response => {
                return response;
            });
    },

    /**
     * Hace la petición de borrado de un usuario al backend por su id y retorna la respuesta
     *
     * @param {int} id
     * @return {Promise<*>}
     */
    delete(id) {
        return apiFetch('/usuarios/' + id + '/eliminar', {
                method: 'DELETE',
            })
            .then(response => {
                return response;
            });
    },

};

export default usersService;