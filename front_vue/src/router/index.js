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
import PublicacionesUsuario from "../components/pages/PublicacionesUsuario";
import Perfil from "../views/Perfil";
import authService from "../services/auth.js";

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
        meta: {
          requiresAuth: true,
        },
      },
      {
        path: 'publicaciones/:id',
        name: 'PublicacionesUsuario',
        component: PublicacionesUsuario,
        meta: {
          requiresAuth: true,
        },
      },
      {
        path: 'favoritos',
        name: 'favoritos',
        component: ComponenteFavoritos,
        meta: {
          requiresAuth: true,
        },
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
    meta: {
      requiresAuth: true,
    }
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

router.beforeEach((to, from) => {
  if (to.meta.requiresAuth && !authService.isAuthenticated()) {
    return {
      path: '/login'
    };
  }
});

export default router