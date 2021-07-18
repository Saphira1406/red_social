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
          <div v-if="auth.user.id !== null" class="navbar-nav ml-auto">
            <div class="nav-item">
              <router-link class="nav-link ml-1" to="/">Home</router-link>
            </div>
            <div class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <img
                  :src="imageUrl(auth.user.imagen)"
                  class="img-fluid avatar mr-2"
                  :alt="
                    `Foto de perfil de ${auth.user.nombre} ${auth.user.apellido}`
                  "
                />
                {{ auth.user.nombre }}
              </a>
              <ul
                class="dropdown-menu"
                id="drop-perfil"
                aria-labelledby="navbarDropdown"
              >
                <li>
                  <router-link
                    to="/perfil"
                    class="dropdown-item drop-hover"
                    href="#"
                    >Perfil</router-link
                  >
                </li>
                <li>
                  <button class="dropdown-item drop-hover" @click="logout">
                    Cerrar Sesión
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <router-view
      @logged="logUser"
      :user="auth.user"
      @updatedUser="onUpdateUser"
      @deletedUser="onDeleteUser"
    />

    <footer>
      <p>Da Vinci &copy; 2021 | Florencia Mellone | Erica Torrico</p>
    </footer>
  </div>
</template>

<script>
import authService from "./services/auth.js";
import { API_IMGS_FOLDER } from "./constants/api.js";
import usersService from "./services/users.js";

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
      usersService.fetch(this.auth.user.id)
        .then(sesion => {
          this.auth.user = sesion;
        });
    },
    onDeleteUser () {
      this.auth.user = {
        id: null,
        email: null,
        usuario: null,
        imagen: null,
        nombre: null,
        apellido: null,
      }
      localStorage.setItem('userData', JSON.stringify(this.auth.user));
    }

  },
  mounted () {
    if (authService.isAuthenticated()) {
      this.auth.user = authService.getUserData();
    }
  }
};
</script>
<style>
#drop-perfil {
  background-color: rgba(242, 137, 114, 0.8);
  left: auto;
  right: 0;
}
.drop-hover:hover {
  background-color: rgba(242, 137, 114, 0.9) !important;
}
.nav-item.dropdown .dropdown-toggle::after {
  margin-left: 0.75em;
}
</style>
