<template>
  <div class="card publicaciones mb-4">
    <!-- Header Republicación -->
    <div v-if="muro_usuario && esRepublicacion" class="card-header">
      <div class="mt-1 mb-1 d-flex align-items-center">
        <img
          :src="imageUrl(muro_usuario.imagen)"
          class="img-fluid avatar"
          alt="Avatar"
        />

        <div>
          <p class="font-weight-bold ml-3 mb-0">
            {{ muro_usuario.nombre + " " + muro_usuario.apellido }}
          </p>
        </div>
        <div
          v-if="
            !(
              publicacion.usuarios_id == muro_usuario.id ||
              publicacion.usuarios_id == user.id ||
              user.id == muro_usuario.id ||
              yaEsAmigo
            )
          "
          class="ml-auto"
        >
          <button
            type="button"
            @click="agregarAmigo"
            class="btn btn-add"
            aria-label="Agregar amigo/a"
            title="Agregar amigo/a"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-plus"
              viewBox="0 0 16 16"
            >
              <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div class="card-body" :class="!esRepublicacion ? 'p-0' : ''">
      <div
        class="card publicaciones bg-transparent"
        :class="!esRepublicacion ? 'border-0' : ''"
      >
        <div class="card-header">
          <div class="mt-1 mb-1 d-flex align-items-center">
            <img
              :src="imageUrl(publicacion.usuario.imagen)"
              class="img-fluid avatar"
              alt="Avatar"
            />

            <div>
              <p class="font-weight-bold ml-3 mb-0">
                {{
                  publicacion.usuario.nombre +
                    " " +
                    publicacion.usuario.apellido
                }}
              </p>
              <p class="small ml-3 mb-0">{{ publicacion.fecha }}</p>
            </div>
            <div
              v-if="
                !(
                  (muro_usuario &&
                    publicacion.usuarios_id == muro_usuario.id) ||
                  publicacion.usuarios_id == user.id ||
                  yaEsAmigo
                )
              "
              class="ml-auto"
            >
              <button
                type="button"
                @click="agregarAmigo"
                class="btn btn-add"
                aria-label="Agregar amigo/a"
                title="Agregar amigo/a"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-plus"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                  />
                </svg>
              </button>
            </div>
          </div>
          <BaseNotification
            v-if="notificationFriend.text !== null"
            :text="notificationFriend.text"
            :type="notificationFriend.type"
            class="mt-3 mb-0"
          />
        </div>

        <img
          v-if="publicacion.imagen !== ''"
          :src="imageUrl(publicacion.imagen)"
          class="img-fluid"
          alt="Imagen de la publicación"
        />

        <div class="card-body">
          <p class="card-text">
            {{ publicacion.texto }}
          </p>
          <button
            type="button"
            class="btn btn-comment"
            data-toggle="collapse"
            :data-target="`#commentForm${publicacion.id}`"
            aria-expanded="false"
            :aria-controls="`commentForm${publicacion.id}`"
            aria-label="Comentar publicación"
            title="Comentar publicación"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-chat-left"
              viewBox="0 0 16 16"
            >
              <path
                d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
              />
            </svg>
          </button>

          <button
            type="button"
            @click="agregarFavorito"
            :disabled="yaEsFavorito"
            :class="[
              !yaEsFavorito
                ? 'btn ml-2 btn-favorite'
                : 'btn ml-2 btn-already-favorite'
            ]"
            :aria-label="
              yaEsFavorito
                ? 'Esta publicación ya está agregada a Favoritos'
                : 'Agregar a Favoritos'
            "
            :title="
              yaEsFavorito
                ? 'Esta publicación ya está agregada a Favoritos'
                : 'Agregar a Favoritos'
            "
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-star"
              viewBox="0 0 16 16"
            >
              <path
                d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"
              />
            </svg>
          </button>

          <button
            type="button"
            @click="republicar"
            class="btn ml-2 btn-share"
            aria-label="Republicar"
            title="Republicar"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-arrow-repeat"
              viewBox="0 0 16 16"
            >
              <path
                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"
              />
              <path
                fill-rule="evenodd"
                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"
              />
            </svg>
          </button>
          <BaseLoader v-if="loading" class="ml-3" size="small" />

          <BaseNotification
            v-if="notificationActions.text !== null"
            :text="notificationActions.text"
            :type="notificationActions.type"
            class="mt-2"
          />

          <div class="collapse" :id="`commentForm${publicacion.id}`">
            <div class="card card-body mt-2 comentario">
              <form action="#" @submit.prevent="crearComentario">
                <div class="form-row">
                  <div class="form-group col-auto">
                    <img
                      :src="imageUrl(user.imagen)"
                      class="img-fluid avatar"
                      alt="Avatar"
                    />
                  </div>
                  <div class="form-group col">
                    <label for="texto" class="form-label"></label>
                    <textarea
                      class="form-control"
                      :id="`comentario${publicacion.id}`"
                      rows="1"
                      placeholder="Escribe un comentario..."
                      v-model.trim="comentario.texto"
                      :aria-describedby="
                        errorsComment.texto !== null
                          ? 'errorsComment-texto'
                          : null
                      "
                      :disabled="loading"
                    ></textarea>
                    <div
                      v-if="errorsComment.texto !== null"
                      id="errorsComment-texto"
                      class="text-danger"
                    >
                      {{ errorsComment.texto }}
                    </div>
                  </div>
                </div>

                <div class="text-center">
                  <button
                    type="submit"
                    class="btn boton boton-publicar btn-gradient"
                    :disabled="loading"
                  >
                    Publicar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <ul
          class="card-footer"
          v-if="Object.keys(publicacion.comentarios).length !== 0"
        >
          <li
            v-for="comentario in publicacion.comentarios"
            :key="comentario.id"
          >
            <div class="mt-1 mb-3 comentario">
              <div class="d-flex align-items-center mx-3">
                <img
                  :src="imageUrl(comentario.usuario.imagen)"
                  class="img-fluid avatar"
                  alt="Avatar"
                />

                <div>
                  <p class="font-weight-bold ml-3 mb-0">
                    {{
                      comentario.usuario.nombre +
                        " " +
                        comentario.usuario.apellido
                    }}
                  </p>
                  <p class="small ml-3 mb-0">{{ comentario.fecha }}</p>
                </div>
              </div>
              <p class="mt-2 mx-3">
                {{ comentario.texto }}
              </p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "./../constants/api.js";
import BaseLoader from "./BaseLoader.vue";
import BaseNotification from "./BaseNotification.vue";
import commentsService from "../services/comments.js";
import friendsService from "../services/friends.js";
import favoritesService from "../services/favorites.js";
import republicationsService from "../services/republications.js";
import $ from 'jquery';

export default {
  name: "UnaPublicacion",
  components: {
    BaseLoader,
    BaseNotification,
  },
  props: ['user', 'publicacion', 'amigos', 'favoritos', 'muro_usuario'],
  emits: ['newComment', 'newFriend', 'newFavorite'],
  data: function () {
    return {
      yaEsAmigo: false,
      amistad: {
        emisor_id: this.user.id,
        receptor_id: this.publicacion.usuarios_id,
      },
      yaEsFavorito: false,
      favorito: {
        usuarios_id: this.user.id,
        publicaciones_id: this.publicacion.id,
      },
      esRepublicacion: false,
      republicacion: {
        usuarios_id: this.user.id,
        publicaciones_id: this.publicacion.id,
      },
      notificationActions: {
        text: null,
        type: 'success',
      },
      notificationFriend: {
        text: null,
        type: 'success',
      },
      loading: false,
      // nuevo comentario:
      comentario: {
        texto: null,
        publicaciones_id: this.publicacion.id,
        usuarios_id: this.user.id,
      },
      errorsComment: {
        texto: null,
      },
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    crearComentario () {
      // Si la petición ya está en ejecución, entonces no repetimos el proceso.
      if (this.loading) return;

      // Si no pasa la validación, no realizamos la petición.
      if (!this.validatesComment()) return;
      this.loading = true;

      this.notificationActions.text = null;
      commentsService.create(this.comentario)
        .then(rta => {
          this.loading = false;
          this.notificationActions.text = rta.msg;
          if (rta.success) {
            this.notificationActions.type = 'success';
            // Luego de grabar exitosamente, ocultamos y vaciamos el form.
            $(`#commentForm${this.comentario.publicaciones_id}`).collapse('hide');
            this.comentario.texto = null;
            this.$emit('newComment', this.publicacion);

          } else {
            this.notificationActions.type = 'danger';
          }
        });
    },

    checkAmigo () {
      let AmigosObj = JSON.parse(JSON.stringify(this.amigos));

      for (let key in AmigosObj) {
        let obj = AmigosObj[key];

        if (obj.receptor_id == this.publicacion.usuarios_id) {
          this.yaEsAmigo = true;
        }
      }
    },

    agregarAmigo () {
      this.notificationFriend = {
        text: null,
      };
      friendsService.create(this.amistad)
        .then(rta => {
          this.notificationFriend.text = rta.msg;
          if (rta.success) {
            this.$emit('newFriend', true);
            this.notificationFriend.type = 'success';
            this.yaEsAmigo = true;
          } else {
            this.notificationFriend.type = 'danger';
            if (rta.debugLog) {
              console.log(rta.debugLog);
            }
          }
        });
    },

    agregarFavorito () {
      this.notificationActions = {
        text: null,
      };
      favoritesService.create(this.favorito)
        .then(rta => {
          this.notificationActions.text = rta.msg;
          if (rta.success) {
            this.$emit('newFavorite', true);
            this.notificationActions.type = 'success';
            this.yaEsFavorito = true;
          } else {
            this.notificationActions.type = 'danger';
            if (rta.debugLog) {
              console.log(rta.debugLog);
            }
          }
        })
    },

    republicar () {
      this.notificationActions.text = null;
      republicationsService.create(this.republicacion)
        .then(rta => {
          this.notificationActions.text = rta.msg;
          if (rta.success) {
            this.notificationActions.type = 'success';
          } else {
            this.notificationActions.type = 'danger';
            if (rta.debugLog) {
              console.log(rta.debugLog);
            }
          }
        })
    },

    checkFavorito () {
      let FavoritoObj = JSON.parse(JSON.stringify(this.favoritos));

      for (let key in FavoritoObj) {
        let obj = FavoritoObj[key];

        if (obj.publicaciones_id == this.publicacion.id) {
          this.yaEsFavorito = true;
        }
      }
    },

    checkRepublicacion () {
      if (this.muro_usuario && this.muro_usuario.id != this.publicacion.usuarios_id) {
        this.esRepublicacion = true;
      }
    },

    /**
    * Valida el form Comentario.
    *
    * @returns boolean
    */
    validatesComment () {
      let commentHasErrors = false;

      if (this.comentario.texto == null || this.comentario.texto === '') {
        this.errorsComment.texto = 'Tenés que escribir el texto del comentario.';
        commentHasErrors = true;
      }

      return !commentHasErrors;
    },

  },
  mounted () {
    this.checkAmigo();
    this.checkFavorito();
    this.checkRepublicacion();
  }
}
</script>

<style scoped>
.icon-edit {
  width: 30px;
}

.comentario {
  background-color: rgba(242, 166, 73, 0.7);
  padding: 0.5em;
  border-radius: 15px;
}

.dropdown-menu {
  background-color: rgb(242, 166, 73);
}

.dropdown-item:hover {
  background-color: rgba(242, 137, 114, 0.7);
}

ul {
  list-style: none;
}
</style>