<template>
  <div>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn text-white boton-editar boton"
      data-toggle="modal"
      data-target="#editForm"
    >
      Editar perfil
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="editForm"
      tabindex="-1"
      aria-labelledby="editFormLabel"
      aria-hidden="true"
      ref="editModal"
    >
      <div class="modal-dialog">
        <div class="modal-content editar">
          <div class="modal-header">
            <h2 class="modal-title h5" id="editFormLabel">Editar Perfil</h2>
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
            <BaseNotification
              v-if="notification.text !== null"
              :text="notification.text"
              :type="notification.type"
            />
            <form action="#" @submit.prevent="editUsuario">
              <div class="form-group text-center">
                <label
                  for="imagenEditar"
                  style="color: #361973; cursor: pointer;"
                >
                  <img
                    v-if="preview"
                    :src="usuario.imagen"
                    alt="Previsualización de la nueva imagen de perfil"
                    class="img-fluid img-profile"
                  />
                  <img
                    v-else
                    :src="imageUrl(usuario.imagen)"
                    class="img-fluid img-profile"
                    :alt="
                      `Foto de perfil de ${usuario.nombre} ${usuario.apellido}`
                    "
                  />
                </label>
                <input
                  type="file"
                  class="form-control-file d-none"
                  id="imagenEditar"
                  ref="editImage"
                  accept="image/x-png,image/jpeg"
                  @change="loadEditImage"
                  :disabled="loading"
                />
                <p><small>Haz click en la imagen para cambiarla</small></p>
              </div>

              <div class="form-group">
                <label for="usuario">Usuario</label>
                <input
                  type="text"
                  class="form-control"
                  id="usuario"
                  v-model.trim="usuario.usuario"
                  :aria-describedby="
                    errors.usuario !== null ? 'errors-usuario' : null
                  "
                  :disabled="loading"
                />
                <div
                  v-if="errors.usuario !== null"
                  id="errors-usuario"
                  class="text-danger"
                >
                  {{ errors.usuario }}
                </div>
              </div>

              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  v-model.trim="usuario.nombre"
                  :aria-describedby="
                    errors.nombre !== null ? 'errors-nombre' : null
                  "
                  :disabled="loading"
                />
                <div
                  v-if="errors.nombre !== null"
                  id="errors-nombre"
                  class="text-danger"
                >
                  {{ errors.nombre }}
                </div>
              </div>

              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input
                  type="text"
                  class="form-control"
                  id="apellido"
                  v-model.trim="usuario.apellido"
                  :aria-describedby="
                    errors.apellido !== null ? 'errors-apellido' : null
                  "
                  :disabled="loading"
                />
                <div
                  v-if="errors.apellido !== null"
                  id="errors-apellido"
                  class="text-danger"
                >
                  {{ errors.apellido }}
                </div>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model.trim="usuario.email"
                  :aria-describedby="
                    errors.email !== null ? 'errors-email' : null
                  "
                  :disabled="loading"
                />
                <div
                  v-if="errors.email !== null"
                  id="errors-email"
                  class="text-danger"
                >
                  {{ errors.email }}
                </div>
              </div>
              <div class="d-flex justify-content-center align-items-end">
                <button
                  type="submit"
                  class="boton w-50 boton-guardar"
                  :disabled="loading"
                >
                  Guardar
                </button>
                <BaseLoader v-if="loading" class="ml-3" size="small" />
              </div>
            </form>

            <section class="card border-danger fondo mt-5 mb-3">
              <div class="card-body text-white">
                <h3 class="card-title h5">Eliminar Cuenta</h3>
                <p class="card-text">
                  Si eliminas tu cuenta se borrarán todos tus datos y
                  publicaciones.
                </p>
                <div class="d-flex justify-content-center">
                  <button
                    type="button"
                    class="btn btn-danger w-50"
                    data-toggle="modal"
                    data-target="#confirmModal"
                  >
                    Eliminar
                  </button>
                </div>

                <div
                  class="modal fade"
                  id="confirmModal"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="confirmModalLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content fondo-eliminar">
                      <div class="modal-header">
                        <p
                          class="modal-title text-white h5"
                          id="confirmModalLabel"
                        >
                          Estás a punto de eliminar tu cuenta
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
                          ¿Estás seguro de eliminar tu cuenta? Esta acción no
                          puede deshacerse.
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
                          @click="deleteUsuario()"
                        >
                          Eliminar cuenta
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "../constants/api";
import BaseLoader from "./BaseLoader.vue";
import BaseNotification from "./BaseNotification.vue";
import usersService from "./../services/users.js";
import $ from 'jquery';

export default {
  name: "Editar",
  props: ['user'],
  emits: [
    'changed',
    'deleted'
  ],
  components: {
    BaseLoader,
    BaseNotification,
  },
  data: function () {
    return {
      usuario: {
        id: this.user.id,
        nombre: this.user.nombre,
        apellido: this.user.apellido,
        email: this.user.email,
        usuario: this.user.usuario,
        imagen: this.user.imagen,
      },
      errors: {
        usuario: null,
        nombre: null,
        apellido: null,
        email: null,
      },
      notification: {
        text: null,
        type: 'success',
      },
      preview: false, loading: false,
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    loadUsuario () {
      usersService.fetch(this.user.id)
        .then(sesion => {
          this.usuario = sesion;
          this.preview = false;
          this.notification.text = null;
          this.errors.usuario = null;
          this.errors.nombre = null;
          this.errors.apellido = null;
          this.errors.email = null;
        });
    },

    /**
    * Lee el archivo de la imagen y lo transforma a base64 para su posterior envío con Ajax.
    */
    loadEditImage () {
      this.preview = true;
      const editReader = new FileReader();
      editReader.addEventListener('load', () => {
        this.usuario.imagen = editReader.result;
      });
      editReader.readAsDataURL(this.$refs.editImage.files[0]);
    },

    editUsuario () {
      // Si la petición ya está en ejecución, entonces no repetimos el proceso.
      if (this.loading) return;

      // Si no pasa la validación, no realizamos la petición.
      if (!this.validates()) return;
      this.loading = true;
      this.notification.text = null;

      let data = {
        id: this.usuario.id,
        nombre: this.usuario.nombre,
        apellido: this.usuario.apellido,
        email: this.usuario.email,
        usuario: this.usuario.usuario,
      };

      // Enviar la imagen sólo si se cambió:
      if (this.preview) {
        data.imagen = this.usuario.imagen;
      }

      usersService.edit(this.usuario.id, data)
        .then(rta => {
          this.loading = false;
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';
            this.$emit('changed', true);
            // Cerrar la modal:
            $('#editForm').modal('hide');
          } else {
            this.notification.type = 'danger';
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

      if (this.usuario.usuario == null || this.usuario.usuario === '') {
        this.errors.usuario = 'Tenés que completar el nombre de usuario.';
        hasErrors = true;
      }

      if (this.usuario.nombre == null || this.usuario.nombre === '') {
        this.errors.nombre = 'Tenés que completar el nombre.';
        hasErrors = true;
      }

      if (this.usuario.apellido == null || this.usuario.apellido === '') {
        this.errors.apellido = 'Tenés que completar el apellido.';
        hasErrors = true;
      }

      if (this.usuario.email == null || this.usuario.email === '') {
        this.errors.email = 'Tenés que completar el email.';
        hasErrors = true;
      }

      return !hasErrors;
    },

    deleteUsuario () {
      usersService.delete(this.usuario.id)
        .then(rta => {
          if (rta.success) {
            this.usuario = {
              nombre: null,
              apellido: null,
              email: null,
              usuario: null,
              imagen: null,
            }

            this.$emit('deleted', true);
            this.$router.push("/");
            // Cerrar la modal:
            $('#editForm').modal('hide');
            $('.modal-backdrop').remove();

          } else {
            this.notification = {
              text: 'Ocurrió un error al tratar de eliminar el usuario.',
              type: 'danger',
            }
          }
        });
    },
  },

  mounted () {
    this.loadUsuario();
    $(this.$refs.editModal).on("hide.bs.modal", this.loadUsuario);
  }
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
  padding: 0.5em;
  box-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
  border-radius: 0.25rem;
}

.img-profile:hover {
  opacity: 0.5;
}
.modal-content.editar,
.fondo {
  background: rgb(54, 25, 115);
  color: white;
}

#confirmModal {
  background: rgba(0, 0, 0, 0.9);
}

.close {
  color: white;
  opacity: 1;
}

.close:hover {
  color: white;
}
</style>
