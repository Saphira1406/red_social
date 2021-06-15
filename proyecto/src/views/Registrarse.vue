<template>
  <section class="container-fluid d-flex justify-content-center align-items-center">
    <div class="card text-white">
      <div class="card-header">
        <h2 class="card-title">Registrate</h2>
      </div>
      <div class="card-body">
        <form action="#" class="row g-3">
          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre">
          </div>
          <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido">
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email">
          </div>
          <div class="col-12">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password">
          </div>
          <div class="d-grid gap-2 col-4 m-auto">
            <button type="submit" class="btn boton">Registrarse</button>
          </div>
        </form>
      </div>
    </div>
  </section>

</template>

<script>
export default {
  name: "Registrarse"
}
</script>

<style scoped>
section {
  background: url("./../assets/img/backgroundLogin.jpg") no-repeat;
  background-size: cover;
  height: 109vh;
  padding-top: 6em;
}
.card {
  width: 60%;
  margin-top: 4em;
  background: rgba(54,25,115, .6);
}

.boton {
  background: rgb(54,25,115);
  background: linear-gradient(351deg, rgba(54,25,115,1) 37%, rgba(172,92,207,1) 87%);
  color: white;
  font-size: 1.2em;
  margin-top: 1em;
}
</style>