<template>
  <main>
    <div
      v-if="!user.id"
      class="home d-md-flex justify-content-md-center align-items-md-center"
    >
      <div class="bg-home"></div>
      <section class="container-fluid">
        <p class="h1">Red Social</p>
        <p>Comparte tus experiencias para que otros puedan aprender de ti</p>
        <div class="d-grid gap-2">
          <router-link
            to="registrarse"
            class="btn boton btn-gradient"
            type="button"
            >Registrate</router-link
          >
        </div>
        <div class="d-grid gap-2 pt-3 mb-2">
          <router-link to="login" class="btn botonLogin" type="button"
            >Iniciar Sesión</router-link
          >
        </div>
      </section>
    </div>
    <seccion-principal v-else :user="user" />
  </main>
</template>

<script>
import SeccionPrincipal from '../components/SeccionPrincipal.vue'


export default {
  components: { SeccionPrincipal },
  name: 'Home',
  props: ['user'],
}
</script>

<style>
main > div:first-child {
  background: rgba(242, 137, 114, 0.1);
  min-height: calc(100vh - 74px - 50px);
}

@media screen and (max-width: 768px) {
  .bg-home {
    width: 100% !important;
    min-height: 40vh !important;
    background-size: cover;
  }
  .home section {
    margin-top: 1em !important;
  }
  .home section .h1 {
    font-size: 4em !important;
  }
  .boton,
  .botonLogin {
    width: 100% !important;
  }
}

.bg-home {
  width: 70%;
  min-height: calc(100vh - 74px - 50px);
  background-image: url("./../assets/img/backgroundHome.jpg");
  background-position: center center;
  background-repeat: no-repeat;
  margin-right: 2.5em;
}

.home section {
  margin-top: -5em;
}

.home section .h1 {
  font-family: "NewYork", serif;
  font-weight: bold;
  font-size: 5em;
}

.home section p {
  font-family: "SourceSansPro", sans-serif;
  font-size: 1.3em;
}

.boton {
  background: rgb(54, 25, 115);
  background: linear-gradient(
    351deg,
    rgba(54, 25, 115, 1) 37%,
    rgba(172, 92, 207, 1) 87%
  );
  color: white;
  margin-top: 1em;
  width: 35%;
  min-width: 180px;
}

body .boton:visited,
body .boton:hover {
  color: white;
}

.botonLogin {
  border: 1px solid #361973 !important;
  color: #361973 !important;
  width: 35%;
  min-width: 180px;
}

.botonLogin:hover {
  background: rgb(54, 25, 115);
  background: linear-gradient(
    351deg,
    rgba(54, 25, 115, 1) 37%,
    rgba(172, 92, 207, 1) 87%
  );
  color: white !important;
}
</style>
