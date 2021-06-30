<template>
  <div class="container">
    <nueva-publicacion :user="user" @newPublication="loadPublications" />

    <!-- Listado de publicaciones: -->
    <div class="loader-container">
      <BaseLoader v-if="loading" />
    </div>
    <div v-for="publicacion in publicaciones" :key="publicacion.id">
      <una-publicacion
        :publicacion="publicacion"
        :user="user"
        @newComment="loadPublications"
      />
    </div>
  </div>
</template>

<script>
import { apiFetch } from "../../functions/fetch.js";
import { API_IMGS_FOLDER } from "../../constants/api.js";
import BaseLoader from "../BaseLoader.vue";
import NuevaPublicacion from "../NuevaPublicacion.vue";
import UnaPublicacion from "../UnaPublicacion.vue";

export default {
  name: "Muro",
  components: {
    BaseLoader,
    NuevaPublicacion,
    UnaPublicacion
  },
  props: ['user'],
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
      apiFetch('/publicaciones')
        .then(publicaciones => {
          this.loading = false;
          // Asignamos las publicaciones al state del componente.
          this.publicaciones = publicaciones;
        });
    },

  },
  mounted () {
    this.loadPublications();
  }
}
</script>

<style scoped>
.loader-container {
  max-width: 50rem;
  margin: 1rem auto;
}
</style>