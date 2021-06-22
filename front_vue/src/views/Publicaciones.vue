<template>
  <section
    id="barra"
    class="publicaciones-seccion card card-btn d-flex justify-content-center align-items-center pt-3"
  >
    <div class="card-body">
      <div class="btn-group" role="group" aria-label="Basic example">
        <router-link to="/publicaciones/" type="button" class="btn  tamaño-btn"
          >Publicaciones</router-link
        >
        <router-link to="/publicaciones/amigos" class="btn  tamaño-btn"
          >Amigos</router-link
        >
        <router-link
          to="/publicaciones/favoritos"
          type="button"
          class="btn  tamaño-btn"
          >Favoritos</router-link
        >
      </div>
    </div>
  </section>
  <section
    class="d-flex justify-content-center align-items-center publicaciones-seccion"
  ></section>

  <section
    v-if="userId"
    class="publicaciones-seccion d-flex justify-content-center align-items-center flex-column pt-3"
  >
    <router-view></router-view>
  </section>
</template>

<script>
export default {
  name: "Publicaciones",
  props: ['userId'],
  emits: ['logged'],
  data () {
    return {

    }
  },
}
</script>

<style scoped>
.publicaciones-seccion {
  background: rgba(242, 137, 114, 0.1);
}
#barra {
  margin-top: 0.001em;
}
.card-btn {
  border: transparent;
}
.tamaño-btn {
  width: 15rem;
  border: 1px solid #361973;
  color: #361973;
}
.tamaño-btn:hover {
  background: rgb(54, 25, 115);
  background: linear-gradient(
    351deg,
    rgba(54, 25, 115, 1) 37%,
    rgba(172, 92, 207, 1) 87%
  );
  color: white !important;
}
.card-body > p {
  margin-left: 1em;
  margin-right: 1em;
}
</style>