<template>
  <div class="pt-3">
    <section
      id="barra"
      class="container bg-transparent card card-btn d-flex justify-content-center align-items-center"
    >
      <div class="pt-3 w-100">
        <div
          class="w-100"
          :class="wideScreen ? 'btn-group' : 'btn-group-vertical'"
          role="group"
          aria-label="Navegación interna"
        >
          <router-link to="/" class="btn barra-btn">Publicaciones</router-link>
          <router-link to="/amigos" class="btn barra-btn">Amigos</router-link>
          <router-link to="/favoritos" class="btn barra-btn"
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
        v-if="friendsLoaded"
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
      friendsLoaded: false,
      // Responsive btn-group "#barra":
      windowWidth: window.innerWidth,
      breakpoint: '576',
      wideScreen: false, initialWidth: '',
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
          this.friendsLoaded = true;
        });
    },

    loadFavorites () {
      this.loading = true;
      favoritesService.fetchAll(this.user.id)
        .then(favoritos => {
          this.loading = false;
          this.favoritos = favoritos;
        });
    },
    onResize () {
      this.windowWidth = window.innerWidth;
    },
    checkWidth (width) {
      if (width >= this.breakpoint) {
        this.wideScreen = true;
      } else {
        this.wideScreen = false;
      }
    }
  },
  watch: {
    windowWidth (newWidth) {
      this.checkWidth(newWidth);
    }
  },
  mounted () {
    this.initialWidth = window.innerWidth; this.checkWidth(this.initialWidth);
    window.addEventListener('resize', this.onResize);
    this.loadFriends();
    this.loadFavorites();
  },
  beforeUnmount () {
    window.removeEventListener('resize', this.onResize);
  },
}
</script>

<style scoped>
#barra {
  margin-top: 0.001em;
}
.card-btn {
  border: transparent;
}
.barra-btn {
  border: 1px solid #361973;
  color: #361973;
}
.barra-btn:hover,
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

@media screen and (min-width: 576px) {
  .barra-btn {
    width: 33.33%;
  }
}

@media (min-width: 992px) {
  #barra {
    max-width: calc(50rem + 30px);
  }
}
</style>