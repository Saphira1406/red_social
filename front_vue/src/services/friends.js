import {
    apiFetch
} from "../functions/fetch.js";

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const friendsService = {
    /**
     * Hace la petición de amigos de un usuario por su id al backend, y de tener éxito, las retorna
     *
     * @param {int} id
     * @return {Promise<*>}
     */
    fetchAll(id) {
        return apiFetch('/amigos/' + id)
            .then(response => {
                return response;
            });
    },

    /**
     * Hace la petición para agregar un amigo al backend y retorna el resultado
     *
     * @param {{}} data
     * @return {Promise<*>}
     */
    create(data) {
        return apiFetch('/amigos/nuevo', {
                method: 'POST',
                body: JSON.stringify(data)
            })
            .then(response => {
                return response;
            });
    },

    /**
     * Hace la petición de borrado de un amigo al backend por su id y retorna la respuesta
     *
     * @param {int} id
     * @return {Promise<*>}
     */
    delete(id) {
        return apiFetch('/amigos/' + id + '/eliminar', {
                method: 'DELETE',
            })
            .then(response => {
                return response;
            });
    },

};

export default friendsService;