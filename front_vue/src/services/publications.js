import {
    apiFetch
} from "../functions/fetch.js";

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const publicationsService = {
    /**
     * Hace la petición de publicaciones al backend, y de tener éxito, las retorna
     *
     * @return {Promise<*>}
     */
    fetchAll() {
        return apiFetch('/publicaciones')
            .then(response => {
                return response;
            });
    },

    /**
     * Hace la petición para crear una publicación al backend y retorna el resultado
     *
     * @param {{}} data
     * @return {Promise<*>}
     */
    create(data) {
        return apiFetch('/publicaciones/nuevo', {
                method: 'POST',
                body: JSON.stringify(data)
            })
            .then(response => {
                return response;
            });
    },

};

export default publicationsService;