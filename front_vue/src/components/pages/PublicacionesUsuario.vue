<template>
  <div class="container">
    <div class="loader-container">
      <BaseLoader v-if="loading" />
    </div>
    <h2 class="mt-3 h5 mb-3">
      Publicaciones de
      <span class="font-weight-bold"
        >{{ usuario.nombre }} {{ usuario.apellido }}</span
      >:
    </h2>
    <ul>
      <li v-for="publicacion in publicaciones" :key="publicacion.id">
        <una-publicacion
          :publicacion="publicacion"
          :user="user"
          :amigos="amigos"
          @newComment="loadPublications"
        />
      </li>
    </ul>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "../../constants/api.js";
import BaseLoader from "../BaseLoader.vue";

import UnaPublicacion from "../UnaPublicacion.vue";
import usersService from "../../services/users.js";
import publicationsService from "../../services/publications.js";

export default {
  name: "PublicacionesUsuario",
  components: {
    BaseLoader,
    UnaPublicacion
  },
  props: ['user', 'amigos'],

  data: function () {
    return {
      loading: false,
      publicaciones: [],
      usuario: [],
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    loadPublications () {
      this.loading = true;

      publicationsService.fetchByUser(this.$route.params.id)
        .then(publicaciones => {
          this.loading = false;
          // Asignamos las publicaciones al state del componente.
          this.publicaciones = publicaciones;
        });
    },

    loadUsuario () {
      usersService.fetch(this.$route.params.id)
        .then(sesion => {
          this.usuario = sesion;
        });
    },

  },
  mounted () {
    this.loadUsuario();
    this.loadPublications();
  }
}
</script>

<style scoped>
ul {
  padding-left: 0;
  list-style: none;
}
</style>