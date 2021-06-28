<template>
  <div v-if="user.id">
    <section class="profile text-center">
      <img
        :src="imageUrl(user.imagen)"
        class="img-profile"
        :alt="`Foto de perfil de ${user.nombre} ${user.apellido}`"
      />
      <p class="font-weight-bold mt-3">{{ user.nombre }} {{ user.apellido }}</p>
    </section>

    <section
      class="info d-flex justify-content-center align-items-center flex-column"
    >
      <router-view :user="user"></router-view>
      <div class="card mt-3 mb-3 card-info" style="width: 35rem;">
        <div class="card-header">
          <p class="h5">Información</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item font-weight-bold">
            Usuario: <span class="texto">{{ user.usuario }}</span>
          </li>
          <li class="list-group-item font-weight-bold">
            Nombre: <span class="texto">{{ user.nombre }}</span>
          </li>
          <li class="list-group-item font-weight-bold">
            Apellido: <span class="texto">{{ user.apellido }}</span>
          </li>
          <li class="list-group-item font-weight-bold">
            Email: <span class="texto">{{ user.email }}</span>
          </li>
        </ul>
      </div>
    </section>
  </div>
</template>

<script>
import { apiFetch } from "../functions/fetch.js";
import { API_IMGS_FOLDER } from "../constants/api";
export default {
  name: "Perfil",
  props: ['user'],
  // emits: ['logged'],
  data: function () {
    return {
      usuario: [],
    }
  },
  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },

    loadUsuario () {
      apiFetch('/usuarios/' + this.user.id)
        .then(sesion => {
          this.usuario = sesion;
        });
    },
  },
  mounted () {
    //this.loadUsuario();
  }
}
</script>

<style scoped>
.profile {
  position: relative;
  background: rgba(242, 137, 114, 0.1);
  z-index: -1;
}
.profile:before {
  position: absolute;
  content: "";
  width: 100%;
  height: 50%;
  top: 0;
  left: 0;
  z-index: -1;
  background: rgb(172, 92, 207);
  background: linear-gradient(
    30deg,
    rgba(172, 92, 207, 0.9107842966288078) 33%,
    rgba(242, 107, 143, 0.90238093528427) 85%
  );
}
.info {
  background: rgba(242, 137, 114, 0.1);
  padding-top: 2em;
  margin-top: -1em;
  padding-bottom: 1em;
  margin-bottom: -1em;
}
.card-info {
  background-color: rgba(242, 166, 73, 0.5);
  font-family: "SourceSansPro", sans-serif;
}
.card-info ul li {
  background-color: rgba(242, 166, 73, 0.1);
}
.img-profile {
  width: 170px;
  border-radius: 50%;
  margin-top: 1.5em;
}
.texto {
  font-weight: normal;
  margin-left: 1em;
}
</style>