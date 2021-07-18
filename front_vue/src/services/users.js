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
     * Hace la petición para crear un usuario al backend y retorna el resultado
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

};

export default usersService;