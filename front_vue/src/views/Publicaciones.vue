<template>
  <section
    id="barra"
    class="publicaciones-seccion card card-btn d-flex justify-content-center align-items-center pt-3"
  >
    <div class="card-body">
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn tamaño-btn">Publicaciones</button>
        <button type="button" class="btn tamaño-btn">Amigos</button>
        <button type="button" class="btn tamaño-btn">Me gusta</button>
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
    <div class="card mb-4 publicaciones" style="width: 50rem;">
      <div class="card-body">
        <form action="#" id="publicar">
          <div class="form-row">
            <div class="form-group col-2" id="img-publish">
              <img
                src="./../assets/img/persona_2.jpg"
                class="img-fluid size-publish"
                alt="foto de perfil"
              />
            </div>
            <div class="form-group col-11">
              <label
                for="exampleFormControlTextarea1"
                class="form-label"
              ></label>
              <textarea
                class="form-control"
                id="exampleFormControlTextarea1"
                rows="1"
                placeholder="¿Qué estás pensando?"
              ></textarea>
            </div>
          </div>
          <div class="form-group">
            <label
              for="exampleFormControlFile1"
              style="color: #361973; cursor: pointer;"
            >
              <img
                src="./../assets/img/image_violeta.png"
                class="img-fluid icono"
                alt="icono de imagen"
              />
              Imagen
            </label>
            <input
              type="file"
              class="form-control-file d-none"
              id="exampleFormControlFile1"
            />
          </div>
          <div class="text-center">
            <button type="submit" class="btn boton boton-publicar">
              Publicar
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="card mb-4 publicaciones" style="width: 50rem;">
      <div class="card-header">
        <div class="mt-1 mb-1 d-flex align-items-end">
          <img
            src="./../assets/img/persona_2.jpg"
            class="img-fluid size"
            alt="foto de perfil"
          />
          <p class="nombre_usuario">Nombre de Usuario</p>
          <button
            href=""
            class="ml-auto align-self-center"
            style="background: none; border: none;"
          >
            <img
              src="./../assets/img/editar.png"
              class="icon-edit"
              alt="icono de editar"
            />
          </button>
        </div>
      </div>
      <img
        src="./../assets/img/group-friends.jpg"
        class="card-img-top img-fluid"
        alt="grupo de amigos"
      />
      <div class="card-body">
        <p class="card-text">
          "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut
          aliquip ex ea commodo consequat. Duis aute irure dolor in
          reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
          pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
          culpa qui officia deserunt mollit anim id est laborum
        </p>
      </div>
      <div class="card-footer">
        <div class="mt-1 mb-3 comentario">
          <p class="nombre_usuario">Nombre de Usuario</p>
          <p class="ml-3 mr-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
        <div class="mt-1 mb-3 comentario">
          <p class="nombre_usuario">Nombre de Usuario</p>
          <p class="ml-3 mr-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
        <div class="mt-1 mb-3 comentario">
          <p class="nombre_usuario">Nombre de Usuario</p>
          <p class="ml-3 mr-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </div>
    </div>

    <div class="card mb-4 publicaciones" style="width: 50rem;">
      <div class="card-header">
        <div class="mt-1 mb-1 d-flex align-items-end">
          <img
            src="./../assets/img/persona_3.jpg"
            class="img-fluid size"
            alt="foto de perfil"
          />
          <p class="nombre_usuario">Nombre de Usuario</p>
          <button
            href=""
            class="ml-auto align-self-center"
            style="background: none; border: none;"
          >
            <img
              src="./../assets/img/editar.png"
              class="icon-edit"
              alt="icono de editar"
            />
          </button>
        </div>
      </div>
      <img
        src="./../assets/img/img-publicacion.jpg"
        class="card-img-top img-fluid"
        alt="grupo de amigos"
      />
      <div class="card-body">
        <p class="card-text">
          "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut
          aliquip ex ea commodo consequat. Duis aute irure dolor in
          reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
          pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
          culpa qui officia deserunt mollit anim id est laborum
        </p>
      </div>
      <div class="card-footer">
        <div class="mt-1 mb-3 comentario">
          <p class="nombre_usuario">Nombre de Usuario</p>
          <p class="ml-3 mr-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
        <div class="mt-1 mb-3 comentario">
          <p class="nombre_usuario">Nombre de Usuario</p>
          <p class="ml-3 mr-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </div>
    </div>
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
.publicaciones {
  background-color: rgba(242, 166, 73, 0.5);
  font-family: "SourceSansPro", sans-serif;
}
.size {
  width: 7%;
  border-radius: 50%;
}
.nombre_usuario {
  font-weight: bold;
  margin-left: 1em;
}
.card-body > p {
  margin-left: 1em;
  margin-right: 1em;
}

.icono {
  width: 30%;
}

.boton-publicar {
  color: white;
  width: 60%;
  border-radius: 20px;
  margin-top: -1em;
}

textarea {
  border-radius: 10px;
  margin-top: -1.5em;
}

select {
  appearance: none;
}

.size-publish {
  width: 45%;
  border-radius: 50%;
}
#img-publish {
  margin-right: -4em;
}

.icon-edit {
  width: 55%;
}

.comentario {
  background-color: rgba(242, 166, 73, 0.7);
  padding: 0.5em;
  border-radius: 15px;
}
</style>