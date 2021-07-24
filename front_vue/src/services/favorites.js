import {
    apiFetch
} from "../functions/fetch";

const favoritesService = {
    fetchAll(id) {
        return apiFetch('/favoritos/' + id)
            .then(response => {
                return response;
            });
    },

    create(data){
        return apiFetch('/favoritos/nuevo', {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(response => {
            return response;
        });
    },

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