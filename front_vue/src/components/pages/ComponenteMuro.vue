<template>
  <div class="container">
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
                class="img-fluid avatar size-publish"
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
                  <label for="imagen" style="color: #361973; cursor: pointer;">
                    <img
                      src="./../../assets/img/image_violeta.png"
                      class="img-fluid icono mr-2"
                      alt="Ícono de imagen"
                    />
                    Agregar imagen
                  </label>
                  <input
                    ref="image"
                    type="file"
                    accept="image/x-png,image/jpeg"
                    class="form-control-file d-none"
                    id="imagen"
                    @change="loadImage"
                  />
                </div>
              </div>
            </div>
          </div>
          <div v-if="publicacion.imagen !== null" class="form-group">
            <p>Previsualización de la imagen seleccionada</p>
            <!-- !! IMPORTANTE !!
                 Este es uno de los casos _muy_ específicos donde el alt de la imagen tiene sentido
                 que quede vacío. Pero es una caso de _excepción_, no una regla.
                 El líneas generales, SIEMPRE tienen que poner un alt descriptivo para la imagen.
                 -->
            <img :src="publicacion.imagen" alt="" />
          </div>
          <div class="text-center">
            <button type="submit" class="btn boton boton-publicar">
              Publicar
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Listado de publicaciones: -->
    <div class="loader-container">
      <BaseLoader v-if="loading" />
    </div>
    <div v-for="publicacion in publicaciones" :key="publicacion.id">
      <una-publicacion
        :publicacion="publicacion"
        :user="user"
        @newComment="loadPublications"
      />
    </div>
  </div>
</template>

<script>
import { apiFetch } from "../../functions/fetch.js";
import { API_IMGS_FOLDER } from "../../constants/api.js";
import BaseLoader from "../BaseLoader.vue";
import BaseNotification from "../BaseNotification.vue";
import UnaPublicacion from "../UnaPublicacion.vue";

export default {
  name: "Muro",
  components: {
    BaseLoader,
    BaseNotification,
    UnaPublicacion
  },
  props: ['user'],
  data: function () {
    return {
      loading: false,
      publicaciones: [],
      usuario: [],

      // nueva publicación:
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
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    loadPublications () {
      this.loading = true;
      apiFetch('/publicaciones')
        .then(publicaciones => {
          this.loading = false;
          // Asignamos las publicaciones al state del componente.
          this.publicaciones = publicaciones;
        });
    },

    /**
 * Lee el archivo de la imagen y lo transforma a base64 para su posterior envío con Ajax.
 */
    loadImage () {
      console.log("El campo de la imagen es: ", this.$refs.image);
      const reader = new FileReader();

      reader.addEventListener('load', () => {
        this.publicacion.imagen = reader.result;
      });

      reader.readAsDataURL(this.$refs.image.files[0]);
    },

    crearPublicacion () {
      // Si la petición ya está en ejecución, entonces no repetimos el proceso.
      // if(this.loading) return;

      // Si no pasa la validación, no realizamos la petición.
      if (!this.validatesPublication()) return;
      // this.loading = true;
      this.notification.text = null;

      apiFetch('/publicaciones/nuevo', {
        method: 'POST',
        body: JSON.stringify(this.publicacion),
      })
        .then(rta => {
          // this.loading = false;
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';
            this.loadPublications();
            // Luego de grabar exitosamente, vaciamos el form y el mensaje de error:
            this.publicacion = {
              texto: null,
              imagen: null,
            };
            this.errors.texto = null;
          } else {
            this.notification.type = 'danger';
            console.log(rta);
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

    /**
    * Valida el form Comentario.
    *
    * @returns boolean
    */
    validatesComment () {
      let commentHasErrors = false;

      if (this.comentario.texto == null || this.comentario.texto === '') {
        this.errors.texto = 'Tenés que escribir el texto del comentario.';
        commentHasErrors = true;
      }

      return !commentHasErrors;
    }
  },
  mounted () {
    this.loadPublications();
  }
}
</script>

<style>
.icono {
  width: 40px;
}

.loader-container {
  max-width: 50rem;
  margin: 1rem auto;
}
</style>