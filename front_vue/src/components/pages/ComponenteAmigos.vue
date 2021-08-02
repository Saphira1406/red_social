<template>
  <div class="container">
    <BaseNotification
      v-if="notification.text !== null"
      :text="notification.text"
      :type="notification.type"
      class="mt-0 sticky-notification"
    />

    <ul v-if="Object.keys(amigos).length" class="row">
      <li
        v-for="amigo in amigos"
        :key="amigo.id"
        class="col-sm-6 col-md-4 col-lg-3"
      >
        <div class="mb-4">
          <div class="card text-center publicaciones">
            <router-link
              :to="'/publicaciones/' + amigo.receptor_id"
              class="to-friend"
            >
              <div class="friend">
                <img
                  :src="imageUrl(amigo.receptor.imagen)"
                  class="img-fluid avatar img-friend"
                  alt="Avatar"
                />
              </div>
              <div class="card-body">
                <div>
                  <p class="card-title h5">
                    {{ amigo.receptor.nombre + " " + amigo.receptor.apellido }}
                  </p>
                </div>
              </div>
            </router-link>

            <div class="card-footer">
              <div class="text-right mt-1">
                <button
                  class="btn btn-delete"
                  type="button"
                  data-toggle="modal"
                  :data-target="`#confirmModal-${amigo.id}`"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-trash2"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div
          class="modal fade"
          :id="`confirmModal-${amigo.id}`"
          tabindex="-1"
          role="dialog"
          :aria-labelledby="`confirmModalLabel-${amigo.id}`"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content fondo-eliminar">
              <div class="modal-header">
                <p
                  class="modal-title text-white h5"
                  :id="`confirmModalLabel-${amigo.id}`"
                >
                  Estás a punto de eliminar a tu amigo
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
                  ¿Estás seguro de eliminar a
                  <span class="font-weight-bold">{{
                    amigo.receptor.nombre + " " + amigo.receptor.apellido
                  }}</span>
                  de tu lista de amigos?
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
                  @click="deleteFriend(amigo.id)"
                >
                  Eliminar amigo
                </button>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>

    <div v-else>
      <p class="text-center mt-5">Aún no hay amigos agregados.</p>
    </div>
  </div>
</template>

<script>
import BaseNotification from "./../BaseNotification.vue";
import { API_IMGS_FOLDER } from "../../constants/api.js";
import friendsService from "./../../services/friends.js";
import $ from 'jquery';

export default {
  name: "Amigos",
  components: {
    BaseNotification,
  },
  props: ['user', 'amigos'],
  emits: ['deletedFriend'],
  data: function () {
    return {
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

    deleteFriend (id) { // id de la fila que se va a borrar de la tabla "amigos"
      this.notification.text = null;
      friendsService.delete(id)
        .then(rta => {
          this.notification.text = rta.msg;
          if (rta.success) {
            this.notification.type = 'success';
            this.$emit('deletedFriend', true);

            // Cerrar la modal:
            $('#confirmModal-' + id).modal('hide');
            $('.modal-backdrop').remove();

          } else {
            this.notification.type = 'danger';
          }
        });
    }
  },
}
</script>

<style scoped>
.img-friend {
  margin-top: 1.5em;
  width: 140px;
  height: 140px;
}

.friend {
  position: relative;
  z-index: 999;
}

.friend:before {
  position: absolute;
  content: "";
  width: 100%;
  height: 65%;
  top: 0;
  left: 0;
  z-index: -1;
  background: rgb(172, 92, 207);
  background: linear-gradient(
    30deg,
    rgba(172, 92, 207, 0.9107842966288078) 33%,
    rgba(242, 107, 143, 0.90238093528427) 85%
  );
}

ul {
  padding-left: 0;
  list-style: none;
}

.to-friend {
  color: initial;
}

.to-friend:hover {
  text-decoration: none;
  filter: contrast(1.25);
  box-shadow: 0 0 10px black;
}
</style>