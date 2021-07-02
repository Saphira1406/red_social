<template>
  <section
    class="container-fluid d-flex justify-content-center align-items-center"
  >
    <div class="card text-white">
      <div class="card-header">
        <h2 class="card-title">Registrate</h2>
      </div>
      <div class="card-body">
        <p class="text-white form-text h6 mb-3">
          (Todos los campos son requeridos)
        </p>

        <BaseNotification
          v-if="notification.text !== null"
          :text="notification.text"
          :type="notification.type"
        />

        <form action="#" class="row g-3" @submit.prevent="crearUsuario">
          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input
              type="text"
              class="form-control"
              id="nombre"
              v-model="usuario.nombre"
              :aria-describedby="
                errors.nombre !== null ? 'errors-nombre' : null
              "
              :disabled="loading"
            />
            <div
              v-if="errors.nombre !== null"
              id="errors-nombre"
              class="text-danger"
            >
              {{ errors.nombre }}
            </div>
          </div>
          <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input
              type="text"
              class="form-control"
              id="apellido"
              v-model="usuario.apellido"
              :aria-describedby="
                errors.apellido !== null ? 'errors-apellido' : null
              "
              :disabled="loading"
            />
            <div
              v-if="errors.apellido !== null"
              id="errors-apellido"
              class="text-danger"
            >
              {{ errors.apellido }}
            </div>
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              v-model="usuario.email"
              :aria-describedby="errors.email !== null ? 'errors-email' : null"
              :disabled="loading"
            />
            <div
              v-if="errors.email !== null"
              id="errors-email"
              class="text-danger"
            >
              {{ errors.email }}
            </div>
          </div>
          <div class="col-12">
            <label for="password" class="form-label">Contraseña</label>
            <input
              type="password"
              class="form-control"
              id="password"
              v-model="usuario.password"
              :aria-describedby="
                errors.password !== null ? 'errors-password' : null
              "
              :disabled="loading"
            />
            <div
              v-if="errors.password !== null"
              id="errors-password"
              class="text-danger"
            >
              {{ errors.password }}
            </div>
          </div>
          <div
            class="w-100 d-flex justify-content-center align-items-end mx-auto"
          >
            <button type="submit" class="btn boton">Registrarse</button>
            <BaseLoader v-if="loading" class="ml-3" size="small" />
          </div>
        </form>
        <p class="text-center mt-3">
          ¿Ya estás registrado?
          <router-link to="login" class="btn btn-link text-white" type="button"
            >Iniciar Sesión</router-link
          >
        </p>
      </div>
    </div>
  </section>
</template>

<script>
import { apiFetch } from "../functions/fetch.js";
import BaseNotification from "../components/BaseNotification.vue";
import BaseLoader from "../components/BaseLoader.vue";

export default {
  name: "Registrarse",
  components: {
    BaseNotification, BaseLoader
  },
  data () {
    return {
      usuario: {
        nombre: null,
        apellido: null,
        email: null,
        password: null,
      },
      errors: {
        nombre: null,
        apellido: null,
        email: null,
        password: null,
      },
      notification: {
        text: null,
        type: 'success',
      },
      loading: false,
    }
  },
  methods: {
    crearUsuario () {
      // Si la petición ya está en ejecución, entonces no repetimos el proceso.
      if (this.loading) return;

      // Si no pasa la validación, no realizamos la petición.
      if (!this.validates()) return;
      this.errors.nombre = null;
      this.errors.apellido = null;
      this.errors.email = null;
      this.errors.password = null;

      this.loading = true;
      this.notification.text = null;

      apiFetch('/usuarios/nuevo', {
        method: 'post',
        body: JSON.stringify(this.usuario),
      })
        .then(rta => {
          this.loading = false;

          if (rta.success) {
            this.$router.push("login");
          } else {
            this.notification.text = rta.msg;
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

      if (this.usuario.nombre == null || this.usuario.nombre === '') {
        this.errors.nombre = 'Tenés que completar el nombre.';
        hasErrors = true;
      }

      if (this.usuario.apellido == null || this.usuario.apellido === '') {
        this.errors.apellido = 'Tenés que completar el apellido.';
        hasErrors = true;
      }

      if (this.usuario.email == null || this.usuario.email === '') {
        this.errors.email = 'Tenés que completar el email.';
        hasErrors = true;
      }

      if (this.usuario.password == null || this.usuario.password === '') {
        this.errors.password = 'Tenés que completar la contraseña.';
        hasErrors = true;
      }

      return !hasErrors;
    },
  },
}
</script>

<style scoped>
section {
  background: url("./../assets/img/backgroundLogin.jpg") no-repeat;
  background-size: cover;
  height: 96vh;
  padding-top: 1em;
}
.card {
  width: 60%;
  margin-top: 1em;
  background: rgba(54, 25, 115, 0.6);
}

.boton {
  background: rgb(54, 25, 115);
  background: linear-gradient(
    351deg,
    rgba(54, 25, 115, 1) 37%,
    rgba(172, 92, 207, 1) 87%
  );
  color: white;
}

.text-danger {
  text-shadow: 0 0 8px rgb(54, 25, 115);
}

.loader {
  background: rgba(255, 255, 255, 0.75);
}
</style>