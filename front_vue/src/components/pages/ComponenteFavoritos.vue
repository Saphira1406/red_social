<template>
  <article class="container">
    <BaseNotification
      v-if="notification.text !== null"
      :text="notification.text"
      :type="notification.type"
      class="mt-0 sticky-notification"
    />
    <!-- <img src="./../../assets/img/soon.png"  class="img-fluid" alt="en construccion">-->
    <div class="card-columns">
      <div class="card publicaciones mb-2">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <img src="./../../assets/img/persona_2.jpg" class="img-fluid avatar" alt="#">
            <p class="font-weight-bold ml-3 mb-0">Nombre Apellido</p>
            <button class="btn btn-delete ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
              </svg>
            </button>
          </div>
        </div>
        <img class="card-img-top" src="./../../assets/img/fondo_login.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        </div>
      </div>

      <div class="card publicaciones mb-2">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <img src="./../../assets/img/persona_3.jpg" class="img-fluid avatar" alt="#">
            <p class="font-weight-bold ml-3 mb-0">Nombre Apellido</p>
            <button class="btn btn-delete ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
              </svg>
            </button>
          </div>
        </div>
        <img class="card-img-top" src="./../../assets/img/backgroundHome.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
      </div>

      <div class="card publicaciones mb-2">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <img src="./../../assets/img/persona_2.jpg" class="img-fluid avatar" alt="#">
            <p class="font-weight-bold ml-3 mb-0">Nombre Apellido</p>
            <button class="btn btn-delete ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
              </svg>
            </button>
          </div>
        </div>
        <img class="card-img-top" src="./../../assets/img/backgroundLogin.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
      </div>

      <div class="card publicaciones mb-2">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <img src="./../../assets/img/persona_2.jpg" class="img-fluid avatar" alt="#">
            <p class="font-weight-bold ml-3 mb-0">Nombre Apellido</p>
            <button class="btn btn-delete ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
      </div>

      <div class="card publicaciones mb-2">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <img src="./../../assets/img/persona_3.jpg" class="img-fluid avatar" alt="#">
            <p class="font-weight-bold ml-3 mb-0">Nombre Apellido</p>
            <button class="btn btn-delete ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
              </svg>
            </button>
          </div>
        </div>
        <img class="card-img-top" src="./../../assets/img/close-up-of-leaf-326055.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
      </div>

      <div class="card publicaciones mb-2">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <img src="./../../assets/img/persona_2.jpg" class="img-fluid avatar" alt="#">
            <p class="font-weight-bold ml-3 mb-0">Nombre Apellido</p>
            <button class="btn btn-delete ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                <path d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z"/>
              </svg>
            </button>
          </div>
        </div>
        <img class="card-img-top" src="./../../assets/img/tierra_wallpaper.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
      </div>

    </div>
  </article>
</template>

<script>
import BaseNotification from "../BaseNotification";
export default {
  name: "Favoritos",
  components: {BaseNotification},
  props: ['user', 'favoritos'],
  data: function () {
    return {
      notification: {
        text: null,
        type: 'success',
      },
    }
  },
}
</script>

<style scoped>
.coming-soon {
  background: none;
  margin-bottom: 2em;
}
</style>