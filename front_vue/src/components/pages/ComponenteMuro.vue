<template>
  <div class="container">
    <nueva-publicacion :user="user" @newPublication="loadPublications" />

    <!-- Listado de publicaciones: -->
    <div class="loader-container">
      <BaseLoader v-if="loading" />
    </div>

    <ul v-if="Object.keys(publicaciones).length">
      <li v-for="publicacion in publicaciones" :key="publicacion.id">
        <una-publicacion
          :publicacion="publicacion"
          :user="user"
          :amigos="amigos"
          :favoritos="favoritos"
          @newComment="loadPublications"
          @newFriend="updateFriend"
          @newFavorite="updateFavorite"
        />
      </li>
    </ul>

    <div v-else>
      <p class="text-center mt-5">Aún no hay publicaciones para mostrar.</p>
    </div>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "../../constants/api.js";
import BaseLoader from "../BaseLoader.vue";
import NuevaPublicacion from "../NuevaPublicacion.vue";
import UnaPublicacion from "../UnaPublicacion.vue";
import publicationsService from "../../services/publications.js";

export default {
  name: "Muro",
  components: {
    BaseLoader,
    NuevaPublicacion,
    UnaPublicacion
  },
  props: ['user', 'amigos', 'favoritos'],
  emits: ['updatedFriend', 'updatedFavorite'],
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

      publicationsService.fetchAll()
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

    updateFriend () {
      this.$emit('updatedFriend', true);
    },

    updateFavorite () {
      this.$emit('updatedFavorite', true);
    },

  },
  mounted () {
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