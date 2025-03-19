import { createRouter, createWebHistory } from 'vue-router';
<<<<<<< HEAD
import LandingView from '@/views/Landing.vue'; // Asegúrate de que el nombre del archivo sea correcto
import LoginView from '@/views/Login.vue';
import UserView from '@/views/UserView.vue'; // Importa la nueva vista del usuario
import EventDetail from '@/components/Events/EventDetail.vue';
import HomeView from '../views/HomeView.vue';
=======
import LandingView from '@/views/Landing.vue';
import LoginView from '@/views/Login.vue';
import UserView from '@/views/UserView.vue';
import EventDetail from '@/components/Events/EventDetail.vue';
import HomeView from '../views/HomeView.vue';
import EventPage from'@/views/PageEvent.vue';
>>>>>>> 6f75e95 (vistas nuevas)

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'landing',
<<<<<<< HEAD
      component: LandingView, // Landing será la vista por defecto
=======
      component: LandingView, 
>>>>>>> 6f75e95 (vistas nuevas)
    },
    {
      path: '/home',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue'), // Lazy loading para AboutView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
<<<<<<< HEAD
    },
    {
      path: '/user',
      name: 'user',
      component: UserView, // Nueva ruta para la vista del usuario
    },
    {
      path: '/event-detail',
      name: 'event-detail',
      component: EventDetail,
=======
>>>>>>> 6f75e95 (vistas nuevas)
    },
    {
      path: '/user',
      name: 'user',
      component: UserView, 
    },
    {
      path: '/event-detail',
      name: 'event-detail',
      component: EventDetail,
    },
    {
      path: '/event-page',
      name: 'event-page',
      component: EventPage,

    }
  ],
});

export default router;