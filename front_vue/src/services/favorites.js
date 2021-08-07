import {
    apiFetch
} from "../functions/fetch";

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const favoritesService = {
    /**
     * Hace la petición de favoritos de un usuario por su id al backend, y de tener éxito, las retorna
     *
     * @param {int} id
     * @return {Promise<*>}
     */
    fetchAll(id) {
        return apiFetch('/favoritos/' + id)
            .then(response => {
                return response;
            });
    },

    /**
     * Hace la petición para agregar un favorito al backend y retorna el resultado
     *
     * @param {{}} data
     * @return {Promise<*>}
     */
    create(data){
        return apiFetch('/favoritos/nuevo', {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(response => {
            return response;
        });
    },

    /**
     * Hace la petición de borrado de un favorito al backend por su id y retorna la respuesta
     *
     * @param {int} id
     * @return {Promise<*>}
     */
    delete(id) {
        return apiFetch('/favoritos/' + id + '/eliminar', {
            method: 'DELETE',
        })
        .then(response => {
            return response;
        });
    }
};

export default favoritesService;