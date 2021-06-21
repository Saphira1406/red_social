import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Registrarse from "../views/Registrarse";
import Publicaciones from "@/views/Publicaciones";
import Login from "@/views/Login";
import Publicacion from "../components/pages/Publicacion";
import Amigos from "../components/pages/Amigos";
import Favoritos from "../components/pages/Favoritos";
import Perfil from "../views/Perfil";


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/registrarse',
    component: Registrarse,
  },
  {
    path: '/login',
    component: Login,
  },
  {
    path: '/perfil',
    component: Perfil,
  },
  {
    path: '/publicaciones',
    component: Publicaciones,
    children: [
      {
        path: '',
        name:'publicacion',
        component: Publicacion,
      },
      {
        path: 'amigos',
        name: 'amigos',
        component: Amigos,
      },
      {
        path: 'favoritos',
        name: 'favoritos',
        component: Favoritos,
      },
    ],
  },

]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
