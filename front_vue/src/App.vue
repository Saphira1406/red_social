<template>
  <div class="d-flex flex-column outer">
    <header>
      <nav
        class="navbar navbar-expand-md navbar-light"
        style="background-color: rgba(242,137,114, .5);"
      >
        <h1 class="mb-0">
          <router-link class="navbar-brand ml-1" to="/">Red Social</router-link>
        </h1>

        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul v-if="auth.user.id !== null" class="navbar-nav ml-auto">
            <!--
            <li class="nav-item">
              <router-link class="nav-link" to="/">Home</router-link>
            </li>
            -->
            <li class="nav-item">
              <router-link class="nav-link px-3" to="/perfil">
                <img
                  :src="imageUrl(auth.user.imagen)"
                  class="img-fluid avatar mr-2"
                  :alt="
                    `Foto de perfil de ${auth.user.nombre} ${auth.user.apellido}`
                  "
                />
                Perfil
              </router-link>
            </li>
            <!--         
          <li v-if="auth.user.id === null" class="nav-item">
            <router-link class="nav-link" to="/login"
              >Iniciar Sesión</router-link
            >
          </li>
          -->
            <li class="nav-item">
              <button class="btn nav-link px-3" @click="logout">
                Cerrar Sesión
              </button>
            </li>
          </ul>

          <!--
          <div class="dropdown" v-if="auth.user.id !== null">
            <button
              class="btn btn-secondary dropdown-toggle"
              type="button"
              id="dropdownMenuButton"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img
                :src="imageUrl(auth.user.imagen)"
                class="img-fluid avatar"
                :alt="
                  `Foto de perfil de ${auth.user.nombre} ${auth.user.apellido}`
                "
              />
              {{ auth.user.nombre }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <router-link class="nav-link" to="/perfil">Perfil</router-link>
              <button class="btn nav-link" @click="logout">
                Cerrar sesión
              </button>
            </div>
          </div>
          -->
        </div>
      </nav>
    </header>

    <router-view
      @logged="logUser"
      :user="auth.user"
      @updatedUser="onUpdateUser"
    />

    <footer>
      <p>Da Vinci &copy; 2021 | Florencia Mellone | Erica Torrico</p>
    </footer>
  </div>
</template>

<script>
import authService from "./services/auth.js";
import { apiFetch } from "./functions/fetch.js";
import { API_IMGS_FOLDER } from "./constants/api.js";

export default {
  data () {
    return {
      auth: {
        user: {
          id: null,
          email: null,
          usuario: null,
          imagen: null,
          nombre: null,
          apellido: null,
        },
      }
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },
    logUser () {
      this.auth.user = authService.getUserData();
    },
    logout () {
      // TODO: Hacer que el logout realmente elimine la cookie.
      // TODO: Hacer que tanto front como back verifiquen que el usuario esté autenticado.
      authService.logout();
      this.auth.user = {
        id: null,
        email: null,
        usuario: null,
        imagen: null,
        nombre: null,
        apellido: null,
      }
      this.$router.push("/");
    },
    onUpdateUser () {
      apiFetch('/usuarios/' + this.auth.user.id)
        .then(sesion => {
          this.auth.user = sesion;
        });

    }
  },
  mounted () {
    // Apenas se monta la App, preguntamos si el usuario está autenticado, y lo marcamos como tal.
    if (authService.isAuthenticated()) {
      this.auth.user = authService.getUserData();
    }
  }
};
</script>
