import { createRouter, createWebHistory } from 'vue-router';
import LandingView from '@/views/Landing.vue'; // Asegúrate de que el nombre del archivo sea correcto
import LoginView from '@/views/Login.vue';
import UserView from '@/views/UserView.vue'; // Importa la nueva vista del usuario
import EventDetail from '@/components/Events/EventDetail.vue';
import HomeView from '../views/HomeView.vue';
import EventCategory from '@/views/EventCategory.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'landing',
      component: LandingView, // Landing será la vista por defecto
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
    },
    {
      path: '/category/:category',
      name: 'EventCategory',
      component: EventCategory,
      props: true
    }
  ],
});

export default router;