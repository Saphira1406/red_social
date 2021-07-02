import {
  createRouter,
  createWebHashHistory
} from 'vue-router'
import Home from '../views/Home.vue'
import Registrarse from "../views/Registrarse";
import Login from "@/views/Login";
import ComponenteMuro from "../components/pages/ComponenteMuro";
import ComponenteAmigos from "../components/pages/ComponenteAmigos";
import ComponenteFavoritos from "../components/pages/ComponenteFavoritos";
import Perfil from "../views/Perfil";

const routes = [{
    path: '/',
    name: 'Home',
    component: Home,
    children: [{
        path: '',
        name: 'publicacion',
        component: ComponenteMuro,
      },
      {
        path: 'amigos',
        name: 'amigos',
        component: ComponenteAmigos,
      },
      {
        path: 'favoritos',
        name: 'favoritos',
        component: ComponenteFavoritos,
      },
    ],
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
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router