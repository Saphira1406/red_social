<template>
  <div class="container">
    <ul class="row">
      <li
        v-for="amigo in amigos"
        :key="amigo.id"
        class="col-sm-6 col-md-4 col-lg-3"
      >
        <div class="mb-4">
          <div class="card text-center publicaciones">
            <div class="friend">
              <img
                :src="imageUrl(amigo.receptor.imagen)"
                class="img-fluid avatar img-friend"
                alt="Avatar"
              />
            </div>
            <div class="card-body">
              <div>
                <p class="card-title h5">
                  {{ amigo.receptor.nombre + " " + amigo.receptor.apellido }}
                </p>
              </div>
            </div>
            <div class="card-footer">
              <div class="text-right mt-1">
                <button class="btn btn-delete">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-trash2"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { API_IMGS_FOLDER } from "../../constants/api.js";

export default {
  name: "Amigos",
  props: ['user', 'amigos'],

  methods: {
    imageUrl (image) {
      return `${API_IMGS_FOLDER}/${image}`;
    },
  },
}
</script>

<style scoped>
.img-friend {
  margin-top: 1.5em;
  width: 140px;
  height: 140px;
}

.friend {
  position: relative;
  z-index: 999;
}
.friend:before {
  position: absolute;
  content: "";
  width: 100%;
  height: 65%;
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

ul {
  padding-left: 0;
  list-style: none;
}
</style>