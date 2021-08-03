<template>
  <div class="pt-3">
    <section
      id="barra"
      class="bg-transparent card card-btn d-flex justify-content-center align-items-center"
    >
      <div class="card-body">
        <div class="btn-group" role="group" aria-label="Navegación interna">
          <router-link to="/" class="btn tamaño-btn">Publicaciones</router-link>
          <router-link to="/amigos" class="btn tamaño-btn">Amigos</router-link>
          <router-link to="/favoritos" class="btn tamaño-btn"
            >Favoritos</router-link
          >
        </div>
      </div>
    </section>

    <div class="container">
      <div class="loader-container">
        <BaseLoader v-if="loading" />
      </div>
    </div>

    <section
      class="d-flex justify-content-center align-items-center flex-column pt-3"
    >
      <router-view
        :user="user"
        :amigos="amigos"
        :favoritos="favoritos"
        @updatedFriend="loadFriends"
        @deletedFriend="loadFriends"
        @updatedFavorite="loadFavorites"
        @deletedFavorite="loadFavorites"
      />
    </section>
  </div>
</template>

<script>
import BaseLoader from "./BaseLoader.vue";
import friendsService from "./../services/friends.js";
import favoritesService from "./../services/favorites";

export default {
  name: "SeccionPrincipal",
  props: ['user'],
  components: {
    BaseLoader,
  },
  data () {
    return {
      loading: false,
      amigos: [],
      favoritos: [],
    }
  },
  methods: {

    loadFriends () {
      this.loading = true;
      friendsService.fetchAll(this.user.id)
        .then(amigos => {
          this.loading = false;
          // Asignamos los amigos al state del componente.
          this.amigos = amigos;
        });
    },

    loadFavorites () {
      this.loading = true;
      favoritesService.fetchAll(this.user.id)
        .then(favoritos => {
          this.loading = false;
          this.favoritos = favoritos; console.log(favoritos);
        });
    },

  },
  mounted () {
    this.loadFriends();
    this.loadFavorites();
  }
}
</script>

<style scoped>
.bg-transparent {
  background: transparent;
}
#barra {
  margin-top: 0.001em;
  /*
  position: sticky;
  top: 0;
  z-index: 9000;
  */
}
.card-btn {
  border: transparent;
}
.tamaño-btn {
  width: 15rem;
  border: 1px solid #361973;
  color: #361973;
  /* background: rgb(255, 231, 227); */
}
.tamaño-btn:hover,
.router-link-exact-active {
  background: rgb(54, 25, 115);
  background: linear-gradient(
    351deg,
    rgba(54, 25, 115, 1) 37%,
    rgba(172, 92, 207, 1) 87%
  );
  color: white !important;
}
.card-body > p {
  margin-left: 1em;
  margin-right: 1em;
}
</style>