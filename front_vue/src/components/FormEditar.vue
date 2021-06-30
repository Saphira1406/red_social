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
                />
                <p><small>Haz click en la imagen para cambiarla</small></p>
              </div>

              <div class="form-group">
                <label for="usuario">Usuario</label>
                <input
                  type="text"
                  class="form-control"
                  id="usuario"
                  v-model="usuario.usuario"
                />
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  v-model="usuario.nombre"
                />
              </div>
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input
                  type="text"
                  class="form-control"
                  id="apellido"
                  v-model="usuario.apellido"
                />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="usuario.email"
                />
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="boton w-50 boton-guardar">
                  Guardar
                </button>
              </div>
            </form>

            <section class="card border-danger fondo mt-5 mb-3">
              <div class="card-body text-white">
                <h5 class="card-title">Eliminar Cuenta</h5>
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
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5
                          class="modal-title text-danger"
                          id="confirmModalLabel"
                        >
                          Estás a punto de eliminar tu cuenta
                        </h5>
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
                        <p class="text-danger">
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
import { apiFetch } from "../functions/fetch.js";
import { API_IMGS_FOLDER } from "../constants/api";
// import authService from "../services/auth.js";
import BaseNotification from "./BaseNotification.vue";

import $ from 'jquery';

export default {
  name: "Editar",
  props: ['user'],
  emits: [
    'changed',
    'deleted'
  ],
  components: {
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
        texto: null
      },
      notification: {
        text: null,
        type: 'success',
      },
      preview: false,
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    loadUsuario () {
      apiFetch('/usuarios/' + this.user.id)
        .then(sesion => {
          this.usuario = sesion;
          this.preview = false;
          this.notification.text = null;
        });
    },

    /**
    * Lee el archivo de la imagen y lo transforma a base64 para su posterior envío con Ajax.
    */
    loadEditImage () {
      // this.loadingImg = true;
      this.preview = true;
      const editReader = new FileReader();
      editReader.addEventListener('load', () => {
        this.usuario.imagen = editReader.result;
        // this.loadingImg = false;
      });
      editReader.readAsDataURL(this.$refs.editImage.files[0]);

    },

    editUsuario () {
      let data = {
        id: this.usuario.id,
        nombre: this.usuario.nombre,
        apellido: this.usuario.apellido,
        email: this.usuario.email,
        usuario: this.usuario.usuario,
      };
      // enviar la imagen sólo si se cambió:
      if (this.preview) {
        data.imagen = this.usuario.imagen;
      }
      apiFetch('/usuarios/' + this.usuario.id + '/editar', {
        method: 'PUT',
        body: JSON.stringify(data),
      })
        .then(rta => {
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';
            this.$emit('changed', true);
            console.log(rta);
            // Cerrar la modal:
            $('#editForm').modal('hide');
          } else {
            this.notification.type = 'danger';
            console.log(rta);
          }
        });
    },

    deleteUsuario () {
      apiFetch('/usuarios/' + this.usuario.id + '/eliminar', {
        method: 'DELETE',
      })
        .then(rta => {
          if (rta.success) {
            console.log(rta);

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
            console.log(rta);
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
</style>
