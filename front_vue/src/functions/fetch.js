// Exportamos una función para simplificar el envío de peticiones a nuestra API.
// Cualquier import de algo que no sea exportado como "default", lo tenemos que importar entre llaves.
import {
    API_HOST
} from "./../constants/api.js";

/**
 * Realiza una petición por fetch a la API.
 *
 * @param {string} url
 * @param {{}} options
 * @return {Promise<any>}
 */
export const apiFetch = function (url, options = {}) {
    // Por defecto, las peticiones por fetch _no_ aceptan ni envían cookies.
    // Si queremos permitir el uso de cookies, tenemos que indicarlo con la opción "credentials":
    // "include".
    options['credentials'] = 'include';
    return fetch(`${API_HOST}${url}`, options)
        .then(res => res.json());
}