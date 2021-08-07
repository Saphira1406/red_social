<template>
  <div>
    <BaseNotification
      v-if="notification.text !== null"
      :text="notification.text"
      :type="notification.type"
    />

    <div class="card mb-4 publicaciones">
      <div class="card-body">
        <form action="#" @submit.prevent="crearPublicacion">
          <div class="form-row">
            <div class="col-auto">
              <img
                :src="imageUrl(user.imagen)"
                class="img-fluid avatar"
                alt="Avatar"
              />
            </div>
            <div class="col">
              <div class="form-row">
                <div class="col-12 form-group">
                  <label for="texto" class="form-label"></label>
                  <textarea
                    class="form-control"
                    id="texto"
                    rows="1"
                    :placeholder="`¿Qué estás pensando, ${user.nombre}?`"
                    v-model.trim="publicacion.texto"
                    :aria-describedby="
                      errors.texto !== null ? 'errors-texto' : null
                    "
                    :disabled="loading"
                  ></textarea>
                  <div
                    v-if="errors.texto !== null"
                    id="errors-texto"
                    class="text-danger"
                  >
                    {{ errors.texto }}
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-12">
                  <label for="imagen" class="mb-0 btn btn-publish">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      class="bi bi-card-image mr-1"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
                      />
                      <path
                        d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z"
                      />
                    </svg>
                    Agregar imagen
                  </label>
                  <BaseLoader v-if="loadingImg" class="ml-3" size="small" />
                  <input
                    ref="image"
                    type="file"
                    accept="image/x-png,image/jpeg"
                    class="form-control-file d-none"
                    id="imagen"
                    @change="loadImage"
                    :disabled="loading"
                  />
                </div>
              </div>
            </div>
          </div>

          <div v-if="publicacion.imagen !== null" class="form-group mt-4">
            <p>Previsualización de la imagen seleccionada:</p>
            <img :src="publicacion.imagen" alt="imagen de la publicación" class="d-block mx-auto" />
          </div>
          <div class="text-center">
            <button
              type="submit"
              class="btn boton boton-publicar btn-gradient"
              :disabled="loading"
            >
              Publicar
            </button>
            <BaseLoader v-if="loading" class="ml-3" size="small" />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "../constants/api.js";
import BaseLoader from "./BaseLoader.vue";
import BaseNotification from "./BaseNotification.vue";
import publicationsService from "../services/publications.js";

export default {
  name: "NuevaPublicacion",
  components: {
    BaseLoader,
    BaseNotification,
  },
  props: ['user'],
  emits: ['newPublication'],
  data: function () {
    return {
      publicacion: {
        texto: null,
        imagen: null,
        usuarios_id: this.user.id,
      },
      errors: {
        texto: null,
      },
      notification: {
        text: null,
        type: 'success',
      },
      loading: false,
      loadingImg: false,
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    /**
    * Lee el archivo de la imagen y lo transforma a base64 para su posterior envío con Ajax.
    */
    loadImage () {
      this.loadingImg = true;
      const reader = new FileReader();
      reader.addEventListener('load', () => {
        this.publicacion.imagen = reader.result;
        this.loadingImg = false;
      });
      reader.readAsDataURL(this.$refs.image.files[0]);
    },

    crearPublicacion () {
      // Si la petición ya está en ejecución, entonces no repetimos el proceso.
      if (this.loading) return;

      // Si no pasa la validación, no realizamos la petición.
      if (!this.validatesPublication()) return;
      this.loading = true;
      this.notification.text = null;

      publicationsService.create(this.publicacion)
        .then(rta => {
          this.loading = false;
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';

            // Luego de grabar exitosamente, vaciamos el form y el mensaje de error:
            this.publicacion.texto = null;
            this.publicacion.imagen = null;

            this.errors.texto = null;

            this.$emit('newPublication', this.publicacion);
          } else {
            this.notification.type = 'danger';
          }
        });
    },

    /**
    * Valida el form Publicación.
    *
    * @returns boolean
    */
    validatesPublication () {
      let publicationHasErrors = false;

      if (this.publicacion.texto == null || this.publicacion.texto === '') {
        this.errors.texto = 'Tenés que escribir el texto de la publicación.';
        publicationHasErrors = true;
      }

      return !publicationHasErrors;
    },

  },

}
</script>

<style scoped>

.comentario {
  background-color: rgba(242, 166, 73, 0.7);
  padding: 0.5em;
  border-radius: 15px;
}
</style>