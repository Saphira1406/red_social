<template>
  <section class="card card-btn d-flex justify-content-center align-items-center mt-3 mb-3">
    <div class="card-body">
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn  tamaño-btn">Publicaciones</button>
        <button type="button" class="btn  tamaño-btn">Amigos</button>
        <button type="button" class="btn  tamaño-btn">Me gusta</button>
      </div>
    </div>
  </section>
</template>

<script>
export default {
name: "Publicaciones"
}
</script>

<style scoped>
.card-btn {
  border: transparent;
}

.tamaño-btn {
  width: 15rem;
  border: 1px solid #361973;
  color: #361973;
}

.tamaño-btn:hover {
  background: rgb(54,25,115);
  background: linear-gradient(351deg, rgba(54,25,115,1) 37%, rgba(172,92,207,1) 87%);
  color: white !important;
}

</style>