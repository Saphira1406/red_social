<template>
  <div v-if="user.id">
    <section class="profile text-center">
      <img
        v-if="usuario.imagen"
        :src="imageUrl(usuario.imagen)"
        class="img-profile"
        alt="avatar"
      />

      <p class="font-weight-bold mt-3">
        {{ usuario.nombre }} {{ usuario.apellido }}
      </p>
    </section>

    <section
      class="info d-flex justify-content-center align-items-center flex-column"
    >
      <form-editar :user="user" @changed="updateUser" @deleted="deleteUser" />

      <div class="card mt-3 mb-3 card-info col-10 col-md-6">
        <div class="card-header">
          <p class="h5">Información</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item font-weight-bold">
            Usuario: <span class="texto">{{ usuario.usuario }}</span>
          </li>
          <li class="list-group-item font-weight-bold">
            Nombre: <span class="texto">{{ usuario.nombre }}</span>
          </li>
          <li class="list-group-item font-weight-bold">
            Apellido: <span class="texto">{{ usuario.apellido }}</span>
          </li>
          <li class="list-group-item font-weight-bold">
            Email: <span class="texto">{{ usuario.email }}</span>
          </li>
        </ul>
      </div>
    </section>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "../constants/api";
import FormEditar from "./../components/FormEditar.vue";
import usersService from "./../services/users.js";

export default {
  name: "Perfil",
  props: ['user'],
  emits: ['updatedUser', 'deletedUser'],
  components: {
    FormEditar
  },
  data: function () {
    return {
      usuario: [],
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
        });
    },

    updateUser () {
      this.loadUsuario();
      this.$emit('updatedUser', true);
    },

    deleteUser () {
      this.$emit('deletedUser', true);
    }

  },
  mounted () {
    this.loadUsuario();
  }
}
</script>

<style scoped>
.profile {
  position: relative;
  background: rgba(242, 137, 114, 0.1);
  z-index: -1;
}
.profile:before {
  position: absolute;
  content: "";
  width: 100%;
  height: 50%;
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
.info {
  background: rgba(242, 137, 114, 0.1);
  padding-top: 2em;
  margin-top: -1em;
  padding-bottom: 1em;
  margin-bottom: -1em;
}
.card-info {
  background-color: rgba(242, 166, 73, 0.5);
  font-family: "SourceSansPro", sans-serif;
  width: 35rem;
}
.card-info ul li {
  background-color: rgba(242, 166, 73, 0.1);
}
.texto {
  font-weight: normal;
  margin-left: 1em;
}
</style>