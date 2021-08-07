<template>
  <article class="container">
    <BaseNotification
      v-if="notification.text !== null"
      :text="notification.text"
      :type="notification.type"
      class="mt-0 sticky-notification"
    />

    <ul v-if="Object.keys(favoritos).length" class="row row-cols-1 row-cols-md-2 list-unstyled">
      <li v-for="favorito in favoritos" :key="favorito.id" class="col mb-4">
        <div class="card publicaciones mb-2">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <img
                :src="imgUrl(favorito.publicacion.usuario.imagen)"
                class="img-fluid avatar"
                alt="#"
              />
              <div>
                <p class="font-weight-bold ml-3 mb-0">{{ favorito.publicacion.usuario.nombre + " " + favorito.publicacion.usuario.apellido }}</p>
                <p class="small ml-3 mb-0">
                  {{ favorito.publicacion.fecha }}
                </p>
              </div>
              <button
                class="btn btn-delete ml-auto"
                data-toggle="modal"
                :data-target="`#confirmModal-${favorito.id}`"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-trash2"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"
                  />
                </svg>
              </button>
            </div>
          </div>
          <img
            class="card-img-top"
            v-if="favorito.publicacion.imagen !== null"
            :src="imgUrl(favorito.publicacion.imagen)"
            alt=""
          />
          <div class="card-body">
            <p class="card-text">{{ favorito.publicacion.texto }}</p>
          </div>
        </div>

        <div
          class="modal fade"
          :id="`confirmModal-${favorito.id}`"
          tabindex="-1"
          role="dialog"
          :aria-labelledby="`confirmModalLabel-${favorito.id}`"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content fondo-eliminar">
              <div class="modal-header">
                <p
                  class="modal-title text-white h5"
                  :id="`confirmModalLabel-${favorito.id}`"
                >
                  Estás a punto de eliminar un favorito
                </p>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Cerrar"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-white">
                  ¿Estás seguro de eliminar la publicación de tu lista de
                  favoritos?
                </p>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Cancelar
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="deleteFavorite(favorito.id)"
                >
                  Eliminar favorito
                </button>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>

    <div v-else>
      <p class="text-center mt-5">Aún no hay favoritos agregados.</p>
    </div>
  </article>
</template>

<script>
import BaseNotification from "../BaseNotification";
import { API_IMGS_FOLDER } from "../../constants/api.js";
import $ from "jquery";
import favoritesService from "../../services/favorites.js";

export default {
  name: "Favoritos",
  components: { BaseNotification },
  props: ['user', 'favoritos'],
  emits: ['deletedFavorite'],
  data: function () {
    return {
      notification: {
        text: null,
        type: 'success',
      },
    }
  },
  methods: {
    imgUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    deleteFavorite (id) { // id de la fila que se va a borrar de la tabla "favoritos"
      this.notification.text = null;
      favoritesService.delete(id)
        .then(rta => {
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';
            this.$emit('deletedFavorite', true);

            // Cerrar la modal:
            $('#confirmModal-' + id).modal('hide');
            $('.modal-backdrop').remove();

          } else {
            this.notification.type = 'danger';
          }
        });
    }
  },

}
</script>

<style scoped>
.coming-soon {
  background: none;
  margin-bottom: 2em;
}
</style>