<template>
  <section class="profile">
    <div class="text-center">
      <img src="./../assets/img/persona_2.jpg" class="img-profile" alt="foto de perfil">
      <p class="font-weight-bold">Nombre de Perfil</p>
    </div>
  </section>

  <section class="info d-flex justify-content-center align-items-center flex-column">
    <div class="card m-5 card-info" style="width: 35rem;">
      <div class="card-header">
        <p class="h5">Información</p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item font-weight-bold">Nombre: </li>
        <li class="list-group-item font-weight-bold">Apellido: </li>
        <li class="list-group-item font-weight-bold">Email: </li>
        <li class="list-group-item font-weight-bold">Fecha de Nacimiento: </li>
        <li class="list-group-item font-weight-bold">Sexo: </li>
        <li class="list-group-item font-weight-bold">Contacto: </li>
      </ul>
    </div>
  </section>
</template>

<script>
export default {
name: "Perfil"
}
</script>

<style scoped>
.profile {
  background: rgb(172,92,207);
  background: linear-gradient(30deg, rgba(172,92,207,0.9107842966288078) 33%, rgba(242,107,143,0.90238093528427) 85%);

}

.info {
  background: rgba(242,137,114, .1);
  padding-top: 1em;
  margin-top: -1em;
  padding-bottom: 1em;
  margin-bottom: -1em;
}

.card-info {
  background-color: rgba(242,166,73, .5);
  font-family: 'SourceSansPro', sans-serif;
}

.card-info ul li{
  background-color: rgba(242,166,73, .1);
}

.img-profile {
  width: 10%;
  border-radius: 50%;
  margin-top: 6.5em;
}
</style>