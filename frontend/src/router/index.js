import { createRouter, createWebHistory } from 'vue-router';
import LandingView from '@/views/Landing.vue';
import LoginView from '@/views/Login.vue';
import UserView from '@/views/UserView.vue';
import EventDetail from '@/components/Events/EventDetail.vue';
import HomeView from '../views/HomeView.vue';
import EventPage from'@/views/PageEvent.vue';
import Registerevent from '@/views/Registerevent.vue';
import Registerpageevent from '@/views/Registerpage.vue';
import EventCategory from '@/views/EventCategory.vue';
import PageEvent from '@/views/PageEvent.vue';
import { isAuthenticated } from '@/services/authService';  // Importa la función para verificar la autenticación

import Myevents from '@/views/Myevents.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'landing',
      component: LandingView, 
    },
    {
      path: '/home',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/user',
      name: 'user',
      component: UserView, 
      meta: { requiresAuth: true },  // Esta ruta requiere autenticación

    },
    {
      path: '/event-detail',
      name: 'event-detail',
      component: EventDetail,
      meta: { requiresAuth: true },  // Esta ruta requiere autenticación

    },
    {
      path: '/category/:category',
      name: 'EventCategory',
      component: EventCategory,
      props: true
    },
    {
      path: '/event-page',
      name: 'event-page',
      component: PageEvent,
      meta: { requiresAuth: true },  // Esta ruta requiere autenticación


    },
    {
      path: '/event-register',
      name: 'event-register',
      component: Registerevent,

    },
    {
      path: '/event-pageregister',
      name: 'event-pageregister',
      component: Registerpageevent,
      meta: { requiresAuth: true },  // Esta ruta requiere autenticación


    },
    {
      path: '/myevents',
      name: 'myevents',
      component: Myevents,
      meta: { requiresAuth: true },  // Esta ruta requiere autenticación


    }
  ],
});

// Guardia global para verificar autenticación antes de acceder a rutas protegidas
router.beforeEach((to, from, next) => {
  // Verificar si la ruta requiere autenticación
  if (to.matched.some(record => record.meta.requiresAuth)) {
    console.log('Verificando autenticación...');  // Agregar log para depuración
    if (!isAuthenticated()) {
      console.log('No autenticado, redirigiendo al login...');
      next({ name: 'login' });  // Redirigir al login si no está autenticado
    } else {
      console.log('Autenticado, permitiendo acceso a la ruta');
      next();  // Permitir acceso a la ruta protegida
    }
  } else {
    next();  // Si la ruta no requiere autenticación, permitir el acceso
  }
});

export default router;