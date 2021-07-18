import {
    apiFetch
} from "../functions/fetch.js";

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const commentsService = {

    /**
     * Hace la petición para crear un comentario al backend y retorna el resultado
     *
     * @param {{}} data
     * @return {Promise<*>}
     */
    create(data) {
        return apiFetch('/comentarios/nuevo', {
                method: 'POST',
                body: JSON.stringify(data)
            })
            .then(response => {
                return response;
            });
    },

};

export default commentsService;