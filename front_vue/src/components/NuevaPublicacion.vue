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
                :alt="`Foto de perfil de ${user.nombre} ${user.apellido}`"
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
                    v-model="publicacion.texto"
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
                  <label
                    for="imagen"
                    class="mb-0"
                    style="color: #361973; cursor: pointer;"
                  >
                    <img
                      src="./../assets/img/image_violeta.png"
                      class="img-fluid icono mr-2"
                      alt="Ícono de imagen"
                    />
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
            <img :src="publicacion.imagen" alt="" class="d-block mx-auto" />
          </div>
          <div class="text-center">
            <button
              type="submit"
              class="btn boton boton-publicar"
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
import { apiFetch } from "../functions/fetch.js";
import { API_IMGS_FOLDER } from "../constants/api.js";
import BaseLoader from "./BaseLoader.vue";
import BaseNotification from "./BaseNotification.vue";

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

      apiFetch('/publicaciones/nuevo', {
        method: 'POST',
        body: JSON.stringify(this.publicacion),
      })
        .then(rta => {
          this.loading = false;
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';

            // Luego de grabar exitosamente, vaciamos el form y el mensaje de error:
            this.publicacion = {
              texto: null,
              imagen: null,
            };
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
.icono {
  width: 40px;
}

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
</style>