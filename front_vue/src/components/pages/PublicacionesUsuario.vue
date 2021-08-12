<template>
  <div class="container">
    <div class="loader-container">
      <BaseLoader v-if="loading" />
    </div>
    <div v-if="Object.keys(publicaciones).length">
      <h2 class="mt-3 h5 mb-4">
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
            :favoritos="favoritos"
            :muro_usuario="usuario"
            @newComment="loadPublications"
          />
        </li>
      </ul>
    </div>
    <div v-else>
      <p class="text-center mt-5">No hay publicaciones para mostrar.</p>
    </div>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "../../constants/api.js";
import BaseLoader from "../BaseLoader.vue";
import UnaPublicacion from "../UnaPublicacion.vue";
import usersService from "../../services/users.js";
import publicationsService from "../../services/publications.js";
import favoritesService from "../../services/favorites";

export default {
  name: "PublicacionesUsuario",
  components: {
    BaseLoader,
    UnaPublicacion
  },
  props: ['user', 'amigos', 'favoritos'],

  data: function () {
    return {
      loading: false,
      publicaciones: [],
      usuario: [],
      favorito: [],
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    loadPublications () {
      this.loading = true;

      publicationsService.fetchByUser(this.$route.params.id)
        .then(rta => {
          this.loading = false;
          if (rta.success) {
            // Asignamos las publicaciones al state del componente.
            this.publicaciones = rta.publicaciones;
          } else if (rta.debugLog) {
            console.log(rta.debugLog);
          }
        });
    },

    loadUsuario () {
      usersService.fetch(this.$route.params.id)
        .then(data => {
          this.usuario = data;
        });
    },

    loadFavorites () {
      this.loading = true;
      favoritesService.fetchAll(this.$route.params.id)
        .then(favoritos => {
          this.loading = false;
          this.favorito = favoritos;
        });
    },

  },
  mounted () {
    this.loadUsuario();
    this.loadFavorites();
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