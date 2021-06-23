import {
  createRouter,
  createWebHashHistory
} from 'vue-router'
import Home from '../views/Home.vue'
import Registrarse from "../views/Registrarse";
// import Publicaciones from "@/views/Publicaciones";
import Login from "@/views/Login";
import ComponentePublicacion from "../components/pages/ComponentePublicacion";
import ComponenteAmigos from "../components/pages/ComponenteAmigos";
import ComponenteFavoritos from "../components/pages/ComponenteFavoritos";
import Perfil from "../views/Perfil";
import FormEditar from "../components/pages/FormEditar";


const routes = [{
    path: '/',
    name: 'Home',
    component: Home,
    children: [{
        path: '',
        name: 'publicacion',
        component: ComponentePublicacion,
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
    children: [{
      path: '',
      component: FormEditar,
    }],
  },
  /*
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
*/
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router