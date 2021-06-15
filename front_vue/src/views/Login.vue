<template>
  <section class="container-fluid d-flex justify-content-center align-items-center">
    <div class="card text-white">
      <div class="card-header">
        <h2 class="card-title">Registrate</h2>
      </div>
      <div class="card-body">
        <form action="#" class="row g-3">
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email">
          </div>
          <div class="col-12">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password">
          </div>
          <div class="d-grid gap-2 w-100 d-flex justify-content-center mx-auto mt-2">
            <button type="submit" class="btn boton mx-auto">Iniciar Sesión</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "Login"
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
  background: rgba(54,25,115, .6);
}

.boton {
  color: white;
}
</style>
