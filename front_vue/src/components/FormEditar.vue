<template>
  <div>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn boton-editar boton"
      data-toggle="modal"
      data-target="#exampleModal"
    >
      Editar perfil
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title h5" id="exampleModalLabel">Editar Perfil</h2>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group text-center">
                <label
                  for="imagen"
                  style="color: #361973; cursor: pointer;"
                >
                  <img
                    :src="imageUrl(user.imagen)"
                    class="img-profile"
                    alt="Cambiar imagen de perfil"
                  />
                </label>
                <input
                  type="file"
                  class="form-control-file d-none"
                  id="imagen"
                />
                <small>Haz click en la imagen para cambiarla</small>
              </div>
              <div class="form-group">
                <label for="usuario">Usuario</label>
                <input
                    type="text"
                    class="form-control"
                    id="usuario"
                    :value="`${user.usuario}`"
                />
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  :value="`${user.nombre}`"
                />
              </div>
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input
                  type="text"
                  class="form-control"
                  id="apellido"
                  :value="`${user.apellido}`"
                />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  :value="`${user.email}`"
                />
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="boton w-50 boton-guardar">Guardar</button>
              </div>
            </form>

            <div class="card border-danger fondo mt-5 mb-3">
              <div class="card-body text-white">
                <h5 class="card-title">Eliminar Cuenta</h5>
                <p class="card-text">
                  Si eliminas tu cuenta se borrarán todos tus datos y
                  publicaciones.
                </p>
                <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-danger w-50">
                    Eliminar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {API_IMGS_FOLDER} from "../constants/api";

export default {
  name: "Editar",
  props: ['user'],
  data: function() {
    return {
      usuario: [],
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },
  },

}
</script>

<style scoped>
.boton-editar {
  color: white;
  border-radius: 20px;
  margin-top: -1em;
}
.boton-guardar {
  border: 1px solid #361973;
  padding: .5em;
}
.img-profile {
  width: 35%;
  border-radius: 50%;
}
.img-profile:hover {
  opacity: 0.5;
}
.modal-content, .fondo{
  background: rgba(54, 25, 115, 0.9);
  color: white;
}
</style>