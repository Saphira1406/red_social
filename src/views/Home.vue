<template>
  <main>
    <section></section>
    <section class="container-fluid">
      <h1>Red Social</h1>
      <p>Comparte tus experiencias para que otros puedan aprender de ti</p>
      <div class="d-grid gap-2 col-4">
        <router-link to="registrarse" class="btn boton" type="button">Registrate</router-link>
      </div>
      <div class="d-grid gap-2 col-4 pt-3">
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
@font-face {
  font-family: 'NewYork';
  src: url("./../assets/tipografia/NewYork.otf");
}

@font-face {
  font-family: 'SourceSansPro';
  src: url("./../assets/tipografia/SourceSansPro-Regular.ttf");
}

main {
  height: 88vh;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  background: rgba(242,137,114, .1);
}

section:nth-child(1) {
  width: 70%;
  height: 88vh;
  background-image: url("./../assets/img/backgroundHome.jpg");
  background-position: center center;
  background-repeat: no-repeat;
  margin-right: 2.5em;
}

section:nth-child(2){
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  margin-top: -10em;
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
  font-size: 1.2em;
  margin-top: 1em;
}

.boton:visited {
  color: white;
}

.botonLogin {
  border: 1px solid #361973 !important;
}

.botonLogin:hover {
  background: rgb(54,25,115);
  background: linear-gradient(351deg, rgba(54,25,115,1) 37%, rgba(172,92,207,1) 87%);
  color: white !important;
}
</style>
