import { createRouter, createWebHistory } from 'vue-router';
import LandingView from '@/views/Landing.vue';
import LoginView from '@/views/Login.vue';
import UserView from '@/views/UserView.vue';
import EventDetail from '@/components/Events/EventDetail.vue';
import HomeView from '../views/HomeView.vue';
import Registerevent from '@/views/Registerevent.vue';
import Registerpageevent from '@/views/Registerpage.vue';
import EventCategory from '@/views/EventCategory.vue';
import PageEvent from '@/views/PageEvent.vue';
import Myevents from '@/views/Myevents.vue';
import { isAuthenticated, isAdmin } from '@/services/authService';  

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
      meta: { requiresAuth: true },  
    },
    {
      path: '/event-detail',
      name: 'event-detail',
      component: EventDetail,
      meta: { requiresAuth: true },  
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
      meta: { requiresAuth: true },  
    },
    {
      path: '/event-register',
      name: 'event-register',
      component: Registerevent,
      meta: { requiresAuth: true, requiresAdmin: true },  // Solo admins

    },
    {
      path: '/event-pageregister',
      name: 'event-pageregister',
      component: Registerpageevent,
      meta: { requiresAuth: true, requiresAdmin: true },  // Solo admins
    },
    {
      path: '/myevents',
      name: 'myevents',
      component: Myevents,
      meta: { requiresAuth: true, requiresAdmin: true },  // Solo admins
    }
  ],
});

router.beforeEach((to, from, next) => {
  console.log(`Intentando acceder a: ${to.fullPath}`);

  // Si ya está autenticado y trata de ir al login, redirigirlo al /user
  if (to.name === 'login' && isAuthenticated()) {
    console.log('Ya estás autenticado, redirigiendo a /user');
    return next({ name: 'user' }); // Evitar que vuelva al login
  }

  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Si no está autenticado, redirigirlo al login
    if (!isAuthenticated()) {
      console.log('No autenticado, redirigiendo al login...');
      return next({ name: 'login', query: { redirect: to.fullPath } });
    }

    // Si es admin y no tiene permisos de admin
    if (to.matched.some(record => record.meta.requiresAdmin) && !isAdmin()) {
      console.log('Acceso denegado. Se requiere rol de administrador.');
      return next({ name: 'landing' });
    }

    console.log('Autenticado, permitiendo acceso...');
    return next();
  }

  next();
});



export default router;
