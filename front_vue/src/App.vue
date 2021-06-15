<template>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: rgba(242,137,114, .5);">
      <a class="navbar-brand ml-1" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/publicaciones">Publicaciones</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/perfil">Perfil</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <router-view></router-view>
  <footer id="footer">
    <p>Copyright &copy; Florencia Mellone | Erica Torrico | Da Vinci 2021</p>
  </footer>
</template>

<script>
export  default {
  data: function () {
    return {

    }
  },
};
</script>

<style lang="scss">
#footer {
  display: flex;
  height: 50px;
  justify-content: center;
  align-items: center;
  background-color: rgba(242,137,114);
  color: #000;
}
#footer p {
  margin: 0;
  text-align: center;
}
</style>
