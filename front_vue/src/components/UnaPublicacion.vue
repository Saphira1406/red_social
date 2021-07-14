<template>
  <div class="card mb-4 publicaciones" :id="`publicacion-${publicacion.id}`">
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
              publicacion.usuario.nombre + " " + publicacion.usuario.apellido
            }}
          </p>
          <p class="small ml-3 mb-0">{{ publicacion.fecha }}</p>
        </div>
        <!-- Editar y eliminar publicación, todavía no agregado al backend:
        <div
          v-if="publicacion.usuarios_id == user.id"
          class="dropdown ml-auto align-self-center"
        >
          <button
            class="btn pr-0"
            type="button"
            :id="`dropdownPublicationMenuButton${publicacion.id}`"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <img
              src="./../assets/img/editar.png"
              class="icon-edit"
              alt="Ícono de editar"
              title="Editar publicación"
              aria-label="Editar publicación"
            />
          </button>
          <div
            class="dropdown-menu"
            :aria-labelledby="`dropdownPublicationMenuButton${publicacion.id}`"
          >
            <a class="dropdown-item" href="#">Editar</a>
            <a class="dropdown-item" href="#">Eliminar</a>
          </div>
        </div>
        -->
      </div>
    </div>

    <img
      v-if="publicacion.imagen !== null"
      :src="imageUrl(publicacion.imagen)"
      class="img-fluid"
      alt=""
    />

    <div class="card-body">
      <p class="card-text">
        {{ publicacion.texto }}
      </p>
      <button
        type="button"
        class="btn btn-gradient"
        data-toggle="collapse"
        :data-target="`#commentForm${publicacion.id}`"
        aria-expanded="false"
        :aria-controls="`commentForm${publicacion.id}`"
      >
        Comentar
      </button>
      <BaseLoader v-if="loading" class="ml-3" size="small" />

      <BaseNotification
        v-if="notification.text !== null"
        :text="notification.text"
        :type="notification.type"
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
                  v-model="comentario.texto"
                  :aria-describedby="
                    errorsComment.texto !== null ? 'errorsComment-texto' : null
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
                class="btn boton boton-publicar"
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
      <li v-for="comentario in publicacion.comentarios" :key="comentario.id">
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
                  comentario.usuario.nombre + " " + comentario.usuario.apellido
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
</template>

<script>
import { API_IMGS_FOLDER } from "./../constants/api.js";
import BaseLoader from "./BaseLoader.vue";
import BaseNotification from "./BaseNotification.vue";
import commentsService from "../services/comments.js";
import $ from 'jquery';

export default {
  name: "UnaPublicacion",
  components: {
    BaseLoader,
    BaseNotification,
  },
  props: ['user', 'publicacion'],
  emits: ['newComment'],
  data: function () {
    return {
      // nuevo comentario:
      comentario: {
        texto: null,
        publicaciones_id: this.publicacion.id,
        usuarios_id: this.user.id,
      },
      errorsComment: {
        texto: null,
      },
      notification: {
        text: null,
        type: 'success',
      },
      loading: false,
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
      this.notification = {
        text: null,
      };
      commentsService.create(this.comentario)
        .then(rta => {
          this.loading = false;
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';
            // Luego de grabar exitosamente, ocultamos y vaciamos el form.
            $(`#commentForm${this.comentario.publicaciones_id}`).collapse('hide');
            this.comentario.texto = null;
            this.$emit('newComment', this.publicacion);

          } else {
            this.notification.type = 'danger';
          }
        });
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