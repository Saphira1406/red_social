import {
    apiFetch
} from "../functions/fetch.js";

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const republicationsService = {

    /**
     * Hace la petición para crear una republicación al backend y retorna el resultado
     *
     * @param {{}} data
     * @return {Promise<*>}
     */
    create(data) {
        return apiFetch('/republicaciones/nuevo', {
                method: 'POST',
                body: JSON.stringify(data)
            })
            .then(response => {
                return response;
            });
    },

};

export default republicationsService;