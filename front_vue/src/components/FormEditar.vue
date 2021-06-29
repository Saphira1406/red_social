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
            <form action="#" @submit.prevent="editUsuario(usuarios.id)">
              <!-- <input type="hidden" name="pk" id="pk" v-model="usuarios.id">
               <div class="form-group text-center">
                 <label
                   for="imagen"
                   style="color: #361973; cursor: pointer;"
                 >
                   <img
                     :src="imageUrl(usuario.imagen)"
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
               </div>-->
              <div class="form-group">
                <label for="usuario">Usuario</label>
                <input
                    type="text"
                    class="form-control"
                    id="usuario"
                    v-model="usuarios.usuario"
                />
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  v-model="usuarios.nombre"
                />
              </div>
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input
                  type="text"
                  class="form-control"
                  id="apellido"
                  v-model="usuarios.apellido"
                />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="usuarios.email"
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
                  <button type="button" class="btn btn-danger w-50"
                  @click="confirmDelete(usuario.id)">
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
import { apiFetch } from "../functions/fetch.js";
import {API_IMGS_FOLDER} from "../constants/api";
import authService from "../services/auth.js";

export default {
  name: "Editar",
  props: ['user'],
  emits: ['logged'],
  data: function() {
    return {
      usuario: [],

      //Editar usuario:
      usuarios: {
        id: this.user.id,
        nombre: this.user.nombre,
        apellido: this.user.apellido,
        email: this.user.email,
        usuario: this.user.usuario,
        //imagen: this.user.imagen,
      },
      errors: {
        texto: null
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

    loadUsuario() {
      apiFetch('/usuarios/' + this.user.id )
          .then(sesion => {
            this.usuario = sesion;
          });
    },

    editUsuario(id) {
      console.log('/usuarios/' + id + '/editar');
      console.log(this.usuarios);

      apiFetch('/usuarios/' + id + '/editar', {
        method: 'PUT',
        body: JSON.stringify(this.usuarios),
      })
        .then(rta => {
          this.notification.text = rta.msg;
          if(rta.success) {
            this.notification.type = 'success';
            this.$router.push("pu");
            //this.loadUsuario();
            console.log(rta);
          } else {
            this.notification.type = 'danger';
            console.log(rta);
          }
        });
    },

    deleteUsuario(id) {
      apiFetch('/usuarios/' + id + '/eliminar', {
        method: 'DELETE',
      })
        .then(rta => {
          this.usuarios = {
            nombre: null,
            apellido: null,
            email: null,
            usuario: null,
            imagen: null,
          }
         authService.logout();
          if(rta.success) {
            console.log(rta);
            this.notification = {
              text: 'El usuario fue eliminado exitosamente.',
              type: 'success',
            };
          } else {
            console.log(rta);
            this.notification = {
              text: 'Ocurrió un error al tratar de eliminar el producto.',
              type: 'danger',
            }
          }
        });
    },

    confirmDelete(id) {
      let confirmacion = confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no puede deshacerse.');

      if (confirmacion) {
        this.deleteUsuario(id);
      }
    },

    validates() {
      let hasErrors = false;

      if (this.usuario.texto == null || this.usuario.texto === '') {
        this.errors.texto = "Los campos no pueden quedar vacíos";
        hasErrors = true;
      }
      return !hasErrors;
    },
  },
  mounted() {
    //this.loadUsuario();
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