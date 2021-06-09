<template>
  <section class="container-fluid mb-3">
    <div class="row">
    <div id="formas" class="split container d-none d-md-flex  ml-0 mr-0">
      <div class="screen">
        <div class="content">
          <h3>Comparte</h3>
          <p>lorem ipsum</p>
        </div>
      </div>
      <div class="screen">
        <div class="content">
          <h3>Comunicate</h3>
          <p>lorem ipsum</p>
        </div>
      </div>
      <div class="screen">
        <div class="content">
          <h3>Encuentras amigos</h3>
          <p>lorem ipsum.</p>
        </div>
      </div>
      <div class="screen">
        <div class="content">
          <h3>Siempre conectado</h3>
          <p>lorem ipsum</p>
        </div>
      </div>
    </div>
    </div>
  </section>
</template>

<script>
export default {
name: "CarrouselHome"
}
</script>

<style scoped>
#formas {
  position: relative;
  height: 60vh;
  display: flex;
  background: #000;
  padding: 0;
}

.screen {
  position: relative;
  flex-grow: 2;
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
  overflow: hidden;
  transition: 1s;
  border-bottom: 1px solid #361973;
}

#formas:hover .screen{
  opacity: 0.1;
}

#formas .screen:hover {
  flex-grow: 5;
  opacity: 1;
}

#formas .screen:nth-child(1) {
  background: url(https://images.pexels.com/photos/789822/pexels-photo-789822.jpeg?auto=format%2Ccompress&cs=tinysrgb&dpr=2&h=750&w=1260);
  background-repeat: no-repeat;
  background-position: center;
}
#formas .screen:nth-child(2) {
  background: url(https://images.pexels.com/photos/1427741/pexels-photo-1427741.jpeg?auto=format%2Ccompress&cs=tinysrgb&dpr=2&h=750&w=1260);
  background-repeat: no-repeat;
  background-position: center;
}
#formas .screen:nth-child(3) {
  background: url(https://images.pexels.com/photos/705792/pexels-photo-705792.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500);
  background-repeat: no-repeat;
  background-position: center;
}

#formas .screen:nth-child(4) {
  background: url(https://images.pexels.com/photos/904276/pexels-photo-904276.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500);
  background-repeat: no-repeat;
  background-position: center;
}

#formas .screen .content {
  position: absolute;
  width: 350px;
  height: auto;
  background: #fff;
  padding: 40px;
  box-sizing: border-box;
  transform: translateX(100%);
  transition: 0.5s;
  text-align: justify;
}
#formas .screen:hover .content {
  transform: translateX(0);
  transition-delay: 0.5s;
}

#formas .screen .content h3 {
  margin: 0;
  padding: 0;
  text-transform: uppercase;
  font-size: 20px;
  color: #361973;
}
</style>