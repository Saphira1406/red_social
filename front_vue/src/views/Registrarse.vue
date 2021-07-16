<template>
  <section
    class="container-fluid d-flex justify-content-center align-items-center"
  >
    <div class="card text-white">
      <div class="card-header">
        <h2 class="card-title">Registrate</h2>
      </div>
      <div class="card-body">
        <span class="form-text text-white h6 mb-3"
          >(Todos los campos son requeridos)</span
        >

        <form action="#" class="row g-3" @submit.prevent="crearUsuario">
          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input
              type="text"
              class="form-control"
              id="nombre"
              v-model="usuario.nombre"
            />
          </div>
          <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input
              type="text"
              class="form-control"
              id="apellido"
              v-model="usuario.apellido"
            />
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              v-model="usuario.email"
            />
          </div>
          <div class="col-12">
            <label for="password" class="form-label">Contraseña</label>
            <input
              type="password"
              class="form-control"
              id="password"
              v-model="usuario.password"
            />
          </div>
          <div class="d-grid gap-2 w-100 d-flex justify-content-center mx-auto">
            <button type="submit" class="btn boton mx-auto">Registrarse</button>
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
export default {
  name: "Registrarse",
  data () {
    return {
      usuario: {
        nombre: null,
        apellido: null,
        email: null,
        password: null,
      },
    }
  },
  methods: {
    crearUsuario () {
      apiFetch('/usuarios/nuevo', {
        method: 'post',
        body: JSON.stringify(this.usuario),
      })
        .then(rta => {
          //  estado.classList.remove('d-none', 'alert-danger', 'alert-success');
          console.log('respuesta del Post', rta);

          if (rta.success) {
            this.$router.push("login");
          }

          /*
                          estado.classList.add('alert');
                          if (responseData.success) {
                              estado.classList.add('alert-success');
          
                              setTimeout(
                                  function () {
                                      location.href = 'login.php';
                                  }, 2000
                              );
                          } else {
                              estado.classList.add('alert-danger');
          
                          }
                          mostrarMensaje(responseData);
                          */
        });
    }
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
  background: rgba(54, 25, 115, 0.9);
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


</style>