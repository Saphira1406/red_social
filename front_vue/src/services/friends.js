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

};

export default friendsService;