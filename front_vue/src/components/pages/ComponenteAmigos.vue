<template>
  <article class="coming-soon">
    <div class="container">
      <div class="row row-cols-1 row-cols-md-3">
        <div class="col mb-4">
          <div class="card text-center">
            <div class="friend">
              <img src="./../../assets/img/persona_2.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card text-center">
            <div class="friend">
              <img src="./../../assets/img/persona_3.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card text-center">
            <div class="friend">
              <img src="./../../assets/img/persona_2.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card text-center">
            <div class="friend">
              <img src="./../../assets/img/persona_3.jpg" class="img-friend" alt="...">
            </div>
            <div class="card-body">
              <div>
                <h5 class="card-title">Nombre Apellido</h5>
                <p class="card-text">Usuario</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </article>


<script>
export default {
  name: "Amigos"
}
</script>

<style scoped>

.usuarios {
  background: rgb(242,137,114);
  background: linear-gradient(94deg, rgba(242,137,114,0.5802520837436538) 21%, rgba(242,166,73,0.6082632882254464) 43%);
}

.img-friend {
  width: 40%;
  border-radius: 50%;
  margin-top: 1.5em;
}

.friend {
  position: relative;
  background: rgba(242, 137, 114, 0.1);
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