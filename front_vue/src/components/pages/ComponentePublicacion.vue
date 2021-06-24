<template>
  <div class="container-fluid">
    <div class="card mb-4 publicaciones">
      <div class="card-body">
        <form action="#" id="publicar">
          <div class="form-row">
            <div class="form-group col-1" id="img-publish">
              <img
                :src="imageUrl(user.imagen)"
                class="img-fluid size-publish"
                :alt="`Foto de perfil de ${user.nombre} ${user.apellido}`"
              />
            </div>
            <div class="form-group col-11">
              <label
                for="exampleFormControlTextarea1"
                class="form-label"
              ></label>
              <textarea
                class="form-control"
                id="exampleFormControlTextarea1"
                rows="1"
                placeholder="¿Qué estás pensando?"
              ></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-11 offset-1">
              <label
                for="exampleFormControlFile1"
                style="color: #361973; cursor: pointer;"
              >
                <img
                  src="./../../assets/img/image_violeta.png"
                  class="img-fluid icono"
                  alt="icono de imagen"
                />
                Agregar imagen
              </label>
              <input
                type="file"
                class="form-control-file d-none"
                id="exampleFormControlFile1"
              />
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
        <div class="card-footer">
          <div class="mt-1 mb-3 comentario">
            <p class="nombre_usuario">Nombre de Usuario</p>
            <p class="mx-3">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
          <div class="mt-1 mb-3 comentario">
            <p class="nombre_usuario">Nombre de Usuario</p>
            <p class="mx-3">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
          <div class="mt-1 mb-3 comentario">
            <p class="nombre_usuario">Nombre de Usuario</p>
            <p class="mx-3">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua.
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

export default {
  name: "Publicacion",
  props: ['user'],
  data: function () {
    return {
      publicaciones: [],
      usuario: [],
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },
    /*
    loadUser (id) {
      // this.loading = true;
      apiFetch('mvc/public/usuarios/' + id)
        .then(usuario => {
          // this.loading = false;
          // Asignamos el usuario al state del componente.
          this.usuario = usuario;
        });
    },
    */
    loadPublications () {
      // this.loading = true;

      apiFetch('mvc/public/publicaciones')
        .then(publicaciones => {
          // this.loading = false;
          // Asignamos las publicaciones al state del componente.
          this.publicaciones = publicaciones;
        });
    },
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
#img-publish {
  /* margin-right: -4em; */
}

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