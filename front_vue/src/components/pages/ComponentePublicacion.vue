<template>
  <div class="container-fluid">
    <BaseNotification
      v-if="notification.text !== null"
      :text="notification.text"
      :type="notification.type"
    />

    <div class="card mb-4 publicaciones">
      <div class="card-body">
        <form action="#" @submit.prevent="crearPublicacion">
          <input type="hidden" id="usuarios_id" :value="user.id" />
          <div class="form-row">
            <div class="form-group col-1">
              <img
                :src="imageUrl(user.imagen)"
                class="img-fluid size-publish"
                :alt="`Foto de perfil de ${user.nombre} ${user.apellido}`"
              />
            </div>
            <div class="form-group col-11">
              <label for="texto" class="form-label"></label>
              <textarea
                class="form-control"
                id="texto"
                rows="1"
                placeholder="¿Qué estás pensando?"
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
            <div class="form-group col-11 offset-1">
              <label for="imagen" style="color: #361973; cursor: pointer;">
                <img
                  src="./../../assets/img/image_violeta.png"
                  class="img-fluid icono mr-2"
                  alt="icono de imagen"
                />
                Agregar imagen
              </label>
              <input type="file" class="form-control-file d-none" id="imagen" />
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn boton boton-publicar">
              Publicar
            </button>
          </div>
        </form>
      </div>
    </div>

    <div v-for="publicacion in publicaciones" :key="publicacion.id">
      <div class="card mb-4 publicaciones">
        <div class="card-header">
          <div class="mt-1 mb-1 d-flex align-items-end">
            <img
              :src="imageUrl(publicacion.usuario.imagen)"
              class="img-fluid
          size"
              :alt="
                `Foto de perfil de ${publicacion.usuario.nombre} ${publicacion.usuario.apellido}`
              "
            />
            <p class="nombre_usuario">
              {{
                publicacion.usuario.nombre + " " + publicacion.usuario.apellido
              }}
            </p>
            <div
              v-if="publicacion.usuarios_id == user.id"
              class="dropdown ml-auto align-self-center"
            >
              <button
                class="btn "
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <img
                  src="./../../assets/img/editar.png"
                  class="icon-edit"
                  alt="icono de editar"
                />
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Editar</a>
                <a class="dropdown-item" href="#">Eliminar</a>
              </div>
            </div>
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
        </div>
        <div
          class="card-footer"
          v-for="comentario in publicacion.comentarios"
          :key="comentario.id"
        >
          <div class="mt-1 mb-3 comentario">
            <div class="d-flex align-items-center mx-3">
              <img
                :src="imageUrl(comentario.usuario.imagen)"
                class="img-fluid
          size"
                :alt="
                  `Foto de perfil de ${comentario.usuario.nombre} ${comentario.usuario.apellido}`
                "
              />
              <p class="nombre_usuario mb-0">
                {{
                  comentario.usuario.nombre + " " + comentario.usuario.apellido
                }}
              </p>
            </div>
            <p class="mt-2 mx-3">
              {{ comentario.texto }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { apiFetch } from "../../functions/fetch.js";
import { API_IMGS_FOLDER } from "../../constants/api.js";
import BaseNotification from "../../components/BaseNotification.vue";

export default {
  name: "Publicacion",
  components: { BaseNotification },
  props: ['user'],
  data: function () {
    return {
      publicaciones: [],
      usuario: [],

      // nueva publicación:
      publicacion: {
        texto: null,
        imagen: null,
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
      // this.loading = true;

      apiFetch('mvc/public/publicaciones')
        .then(publicaciones => {
          // this.loading = false;
          // Asignamos las publicaciones al state del componente.
          this.publicaciones = publicaciones;
        });
    },

    crearPublicacion () {
      // Si la petición ya está en ejecución, entonces no repetimos el proceso.
      // if(this.loading) return;

      // Si no pasa la validación, no realizamos la petición.
      if (!this.validates()) return;
      // this.loading = true;
      this.notification = {
        text: null,
      };
      apiFetch('mvc/public/publicaciones/nuevo', {
        method: 'POST',
        body: JSON.stringify(this.publicacion),
        headers: {
          // Si bien a esta altura no nos es estrictamente necesario, siempre deberíamos ser
          // prolijos y aclarar el tipo de dato de lo que estamos enviando desde la petición
          // al servidor.
          'Content-Type': 'application/json',
        }
      })
        .then(rta => {
          // this.loading = false;
          console.log(rta);
          if (rta.success) {
            this.notification = {
              text: 'La publicación se creó con éxito.',
              type: 'success',
            };
            // Luego de grabar exitosamente, vaciamos el form.
            this.publicacion = {
              texto: null,
              imagen: null,
            };
            console.log("La publicación se creó con éxito.");
          } else {
            this.notification = {
              text: 'Ocurrió un error inesperado en el servidor y la publicación no pudo ser creada.',
              type: 'danger',
            };
            console.log("Ocurrió un error inesperado y la publicación no pudo ser creada.");
          }
        });
    },

    /**
    * Valida el form.
    *
    * @returns boolean
    */
    validates () {
      let hasErrors = false;

      if (this.publicacion.texto == null || this.publicacion.texto === '') {
        this.errors.texto = 'Tenés que escribir el texto de la publicación.';
        hasErrors = true;
      }

      return !hasErrors;
    }
  },
  mounted () {
    //  this.loadUser(this.user);
    this.loadPublications();
  }
}
</script>

<style scoped>
.publicaciones {
  background-color: rgba(242, 166, 73, 0.5);
  font-family: "SourceSansPro", sans-serif;
  max-width: 50rem;
  margin: auto;
}
.size {
  width: 7%;
  border-radius: 50%;
}
.nombre_usuario {
  font-weight: bold;
  margin-left: 1em;
}

.icono {
  width: 30%;
}

.boton-publicar {
  color: white;
  width: 60%;
  border-radius: 20px;
  margin-top: -1em;
}

.size-publish {
  /* width: 45%; */
  border-radius: 50%;
}
/* #img-publish {
   margin-right: -4em; 
} */

.icon-edit {
  width: 45%;
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

textarea {
  border-radius: 10px;
  margin-top: -1.5em;
}
</style>