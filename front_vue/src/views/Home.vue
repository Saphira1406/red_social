<template>
  <main>
    <div
      v-if="!user.id"
      class="home d-flex justify-content-center align-items-center"
    >
      <div class="bg-home"></div>
      <section class="container-fluid">
        <p class="h1">Red Social</p>
        <p>Comparte tus experiencias para que otros puedan aprender de ti</p>
        <div class="d-grid gap-2">
          <router-link to="registrarse" class="btn boton" type="button"
            >Registrate</router-link
          >
        </div>
        <div class="d-grid gap-2 pt-3">
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
// @ is an alias to /src

export default {
  components: { SeccionPrincipal },
  name: 'Home',
  props: ['user'],
}
</script>

<style>
main > div:first-child {
  background: rgba(242, 137, 114, 0.1);
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

.boton:visited {
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
