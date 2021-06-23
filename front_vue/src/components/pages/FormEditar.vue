<template>
  <!-- Button trigger modal -->
  <button type="button" class="btn boton-editar boton w-25" data-toggle="modal" data-target="#exampleModal">
    Editar perfil
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title h5" id="exampleModalLabel">Editar Perfil</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group text-center">
              <label for="exampleFormControlFile1" style="color: #361973; cursor: pointer;">
                <img src="./../../assets/img/persona_2.jpg" class="img-profile" alt="Cambiar imagen de perfil">
              </label>
              <input type="file" class="form-control-file d-none" id="exampleFormControlFile1">
            </div>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" id="nombre" placeholder="Nombre">
            </div>
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" placeholder="Apellido">
              </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" placeholder="ejemplo@mail.com">
            </div>
            <div class="form-group">
              <label for="fecha">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="fecha" placeholder="Another input placeholder">
            </div>
            <div class="form-group">
              <label for="sexo">Sexo</label>
              <select class="form-control" id="sexo">
                <option>Mujer</option>
                <option>Hombre</option>
                <option>No Binario</option>
              </select>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="boton p-1 w-50">Guardar</button>
            </div>
          </form>

          <div class="card border-danger mt-5 mb-3">
            <div class="card-body text-danger">
              <h5 class="card-title">Eliminar Cuenta</h5>
              <p class="card-text">Si eliminas tu cuenta se borrarán todos tus datos y publicaciones.</p>
              <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-danger w-50">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  name: "Editar"
}
</script>

<style scoped>
.boton-editar {
  color: white;
  border-radius: 20px;
  margin-top: -1em;
}
.img-profile {
  width: 35%;
  border-radius: 50%;
}
.img-profile:hover {
  opacity: .5;
}
</style>