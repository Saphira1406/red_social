<template>
  <main class="d-flex justify-content-center align-items-center">
    <section></section>
    <section class="container-fluid">
      <h1>Red Social</h1>
      <p>Comparte tus experiencias para que otros puedan aprender de ti</p>
      <div class="d-grid gap-2">
        <router-link to="registrarse" class="btn boton" type="button">Registrate</router-link>
      </div>
      <div class="d-grid gap-2 pt-3">
        <router-link to="login" class="btn botonLogin" type="button">Iniciar Sesión</router-link>
      </div>
    </section>
  </main>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'Home',
}
</script>

<style>

main {
  height: 83vh;
  background: rgba(242,137,114, .1);
}

section:nth-child(1) {
  width: 70%;
  height: 83vh;
  background-image: url("./../assets/img/backgroundHome.jpg");
  background-position: center center;
  background-repeat: no-repeat;
  margin-right: 2.5em;
}

section:nth-child(2){
  margin-top: -5em;
}

section:nth-child(2) h1 {
  font-family: 'NewYork', serif;
  font-weight: bold;
  font-size: 5em;
}

section:nth-child(2) p {
  font-family: 'SourceSansPro', sans-serif;
  font-size: 1.3em;
}

.boton {
  background: rgb(54,25,115);
  background: linear-gradient(351deg, rgba(54,25,115,1) 37%, rgba(172,92,207,1) 87%);
  color: white;
  margin-top: 1em;
  width: 35%;
}

.boton:visited {
  color: white;
}

.botonLogin {
  border: 1px solid #361973 !important;
  color: #361973 !important;
  width: 35%;
}

.botonLogin:hover {
  background: rgb(54,25,115);
  background: linear-gradient(351deg, rgba(54,25,115,1) 37%, rgba(172,92,207,1) 87%);
  color: white !important;
}
</style>
