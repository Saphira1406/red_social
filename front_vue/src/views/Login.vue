<template>
  <section
    class="container-fluid d-flex justify-content-center align-items-center"
  >
    <div class="card text-white">
      <div class="card-header">
        <h2 class="card-title">Iniciar sesión</h2>
      </div>
      <div class="card-body">
        <form action="#" class="row g-3" method="post" @submit.prevent="login">
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              name="email"
              id="email"
              class="form-control"
              v-model="user.email"
            />
          </div>
          <div class="col-12">
            <label for="password" class="form-label">Contraseña</label>
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              v-model="user.password"
            />
          </div>
          <div
            class="d-grid gap-2 w-100 d-flex justify-content-center mx-auto mt-2"
          >
            <button type="submit" class="btn boton mx-auto">
              Iniciar Sesión
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
// import {apiFetch} from "../functions/fetch.js";
import authService from "../services/auth.js";

export default {
  name: "Login",
  emits: ['logged'],
  data () {
    return {
      user: {
        email: null,
        password: null
      },
      loading: false,
      notification: {
        text: null,
        type: 'success',
      },
    };
  },
  methods: {
    login () {
      // TODO: Validar el form...
      this.loading = true;
      authService
        .login(this.user.email, this.user.password)
        .then(response => {
          // this.loading = false;
          console.log(response);
          if (response.success) {
            this.$emit('logged', response.data);
            this.$router.push("/");
          }
        });
    }
  }
}
</script>

<style scoped>
section {
  background: url("./../assets/img/backgroundLogin.jpg") no-repeat;
  background-size: cover;
  height: calc(100vh - 73px - 50px);
  padding-top: 1em;
}
.card {
  width: 60%;
  margin-top: 1em;
  background: rgba(54, 25, 115, 0.6);
}

.boton {
  color: white;
}
</style>
