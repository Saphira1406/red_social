<template>
  <header>
    <nav
      class="navbar navbar-expand-lg navbar-light"
      style="background-color: rgba(242,137,114, .5);"
    >
      <h1>
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
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/publicaciones"
              >Publicaciones</router-link
            >
          </li>
          <li v-if="auth.user.id !== null" class="nav-item">
            <router-link class="nav-link" to="/perfil">Perfil</router-link>
          </li>
          <li v-if="auth.user.id === null" class="nav-item">
            <router-link class="nav-link" to="/login"
              >Iniciar Sesión</router-link
            >
          </li>
          <li v-else class="nav-item">
            <button class="btn nav-link" @click="logout">
              {{ auth.user.email }} (Cerrar Sesión)
            </button>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <router-view @logged="logUser" :userId="auth.user.id"></router-view>

  <footer id="footer">
    <p>Copyright &copy; Florencia Mellone | Erica Torrico | Da Vinci 2021</p>
  </footer>
</template>

<script>
import authService from "./services/auth.js";

export default {
  data () {
    return {
      auth: {
        user: {
          id: null,
          email: null,
          usuario: null,
        },
      }
    }
  },
  methods: {
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
      }
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

<style lang="scss">
@font-face {
  font-family: "NewYork";
  src: url("./assets/tipografia/NewYork.otf");
}

@font-face {
  font-family: "SourceSansPro";
  src: url("./assets/tipografia/SourceSansPro-Regular.ttf");
}

#footer {
  display: flex;
  height: 50px;
  justify-content: center;
  align-items: center;
  background-color: rgba(242, 137, 114);
  color: #000;
}
#footer p {
  margin: 0;
  text-align: center;
}
</style>
