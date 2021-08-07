<template>
  <section
    class="container-fluid d-flex justify-content-center align-items-center"
  >
    <div class="card text-white">
      <div class="card-header">
        <h2 class="card-title">Iniciar sesión</h2>
      </div>
      <div class="card-body">
        <BaseNotification
          v-if="notification.text !== null"
          :text="notification.text"
          :type="notification.type"
        />

        <form action="#" class="row g-3" method="post" @submit.prevent="login">
          <div class="col-12 mb-5">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              name="email"
              id="email"
              class="form-control"
              v-model.trim="user.email"
              :aria-describedby="errors.email !== null ? 'errors-email' : null"
              :disabled="loading"
            />
            <div
              v-if="errors.email !== null"
              id="errors-email"
              class="text-error"
            >
              {{ errors.email }}
            </div>
          </div>
          <div class="col-12 mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              v-model.trim="user.password"
              :aria-describedby="
                errors.password !== null ? 'errors-password' : null
              "
              :disabled="loading"
            />
            <div
              v-if="errors.password !== null"
              id="errors-password"
              class="text-error"
            >
              {{ errors.password }}
            </div>
          </div>
          <div
            class="d-flex justify-content-center align-items-end mx-auto mt-2"
          >
            <button type="submit" class="btn boton mx-auto" :disabled="loading">
              Iniciar Sesión
            </button>
            <BaseLoader v-if="loading" class="ml-3" size="small" />
          </div>
        </form>
        <p class="text-center mt-3">
          ¿Aún no estás registrado?
          <router-link
            to="registrarse"
            class="btn btn-link text-white"
            type="button"
            >Registrate</router-link
          >
        </p>
      </div>
    </div>
  </section>
</template>

<script>
import BaseNotification from "../components/BaseNotification.vue";
import BaseLoader from "../components/BaseLoader.vue";
import authService from "../services/auth.js";

export default {
  name: "Login",
  components: {
    BaseNotification, BaseLoader
  },
  emits: ['logged'],
  data () {
    return {
      user: {
        email: null,
        password: null
      },
      loading: false,
      errors: {
        email: null,
        password: null,
      },
      notification: {
        text: null,
        type: 'success',
      },
    };
  },
  methods: {
    login () {
      // Si la petición ya está en ejecución, entonces no repetimos el proceso.
      if (this.loading) return;

      // Si no pasa la validación, no realizamos la petición.
      if (!this.validates()) return;
      this.errors.email = null;
      this.errors.password = null;

      this.loading = true;
      this.notification.text = null;

      authService.login(this.user.email, this.user.password)
        .then(response => {
          this.loading = false;

          if (response.success) {
            this.$emit('logged', response.data);
            this.$router.push("/");
          } else {
            this.notification.text = response.msg;
            this.notification.type = 'danger';
          }
        });
    },

    /**
    * Valida el form.
    *
    * @returns boolean
    */
    validates () {
      let hasErrors = false;

      if (this.user.email == null || this.user.email === '') {
        this.errors.email = 'Tenés que completar el email.';
        hasErrors = true;
      }

      if (this.user.password == null || this.user.password === '') {
        this.errors.password = 'Tenés que completar la contraseña.';
        hasErrors = true;
      }

      return !hasErrors;
    },
  }
}
</script>

<style scoped>
section {
  background: url("./../assets/img/backgroundLogin.jpg") no-repeat;
  background-size: cover;
  height: calc(100vh - 74px - 50px);
}
.card {
  width: 60%;
  margin-top: 1em;
  background: rgba(54, 25, 115, 0.9);
}

.boton {
  color: white;
}
</style>
