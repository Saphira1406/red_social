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
          data-target="#mainNavBar"
          aria-controls="mainNavBar"
          aria-expanded="false"
          aria-label="Menú hamburguesa"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavBar">
          <ul v-if="auth.user.id !== null" class="navbar-nav ml-auto">
            <li class="nav-item">
              <router-link class="nav-link ml-1" to="/">Home</router-link>
            </li>
            <li class="nav-item dropdown">
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
                  alt="Avatar"
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
                    :to="'/publicaciones/' + auth.user.id"
                    class="dropdown-item drop-hover"
                    >Mis publicaciones</router-link
                  >
                </li>
                <li>
                  <router-link to="/perfil" class="dropdown-item drop-hover"
                    >Perfil</router-link
                  >
                </li>
                <li>
                  <button class="dropdown-item drop-hover" @click="logout">
                    Cerrar Sesión
                  </button>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <BaseNotification
      v-if="notification.text !== null"
      :text="notification.text"
      :type="notification.type"
      class="fixed-notification"
    />

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
import BaseNotification from "./components/BaseNotification.vue";

export default {
  components: {
    BaseNotification,
  },
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
      },
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
      this.notification.text = "Tu perfil ha sido actualizado.";
      this.notification.type = 'success';
    },
    onDeleteUser () {

      this.notification.text = "Tu perfil ha sido eliminado.";
      this.notification.type = 'success';

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
