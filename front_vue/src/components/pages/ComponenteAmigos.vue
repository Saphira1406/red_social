<template>
  <article class="coming-soon">
    <div class="container">
      <div class="row row-cols-1 row-cols-md-3">
        <div class="col mb-4">
          <div class="card text-center publicaciones">
            <div class="friend">
              <img src="./../../assets/img/persona_2.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
              <div class="text-right mt-n4">
              <button class="btn btn-delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                  <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
                </svg>
              </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card text-center publicaciones">
            <div class="friend">
              <img src="./../../assets/img/persona_3.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
              <div class="text-right mt-n4">
                <button class="btn btn-delete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                    <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card text-center publicaciones">
            <div class="friend">
              <img src="./../../assets/img/persona_2.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
              <div class="text-right mt-n4">
                <button class="btn btn-delete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                    <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card text-center publicaciones">
            <div class="friend">
              <img src="./../../assets/img/persona_3.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
              <div class="text-right mt-n4">
                <button class="btn btn-delete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                    <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>
</template>

<script>
export default {
  name: "Amigos"
}
</script>

<style scoped>
.img-friend {
  width: 40%;
  border-radius: 50%;
  margin-top: 1.5em;
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

</style>