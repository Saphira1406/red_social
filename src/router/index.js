import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Registrarse from "../views/Registrarse";
import Perfil from "@/views/Perfil";
import Publicaciones from "@/views/Publicaciones";
import Login from "@/views/Login";

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
  },

]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
