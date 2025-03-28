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
import AccountView from '@/views/Account.vue';
import VenueRegister from '@/views/VenueRegister.vue';
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
      path: '/events/event-detail/:title',
      name: 'EventDetail',
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
      meta: { requiresAuth: true, requiresAdmin: true },  
    },
    {
      path: '/event-pageregister',
      name: 'event-pageregister',
      component: Registerpageevent,
      meta: { requiresAuth: true, requiresAdmin: true },  
    },
    {
      path: '/myevents',
      name: 'myevents',
      component: Myevents,
      meta: { requiresAuth: true, requiresAdmin: true },  
    },
    {
      path: '/account',
      name: 'account',
      component: AccountView,
      meta: { requiresAuth: true },
    },
    {
      path: '/venue-register',
      name: 'venue-register',
      component: VenueRegister,
      meta: { requiresAuth: true, requiresAdmin: true },
    }
  ],
});

router.beforeEach((to, from, next) => {
  console.log(`Intentando acceder a: ${to.fullPath}`);

  if (to.name === 'login' && isAuthenticated()) {
    console.log('Ya estás autenticado, redirigiendo a la página principal...');
    return next({ name: 'landing' }); 
  }

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated()) {
      console.log('No autenticado, redirigiendo al login...');
      return next({ name: 'login', query: { redirect: to.fullPath } });
    }

    if (to.matched.some(record => record.meta.requiresAdmin) && !isAdmin()) {
      console.log('Acceso denegado. Se requiere rol de administrador. Redirigiendo al inicio...');
      return next({ name: 'landing' }); 
    }

    if (to.name === 'user' && isAdmin()) {
      console.log('Los administradores no pueden acceder a esta ruta. Redirigiendo a la página de inicio...');
      return next({ name: 'landing' }); 
    }

    console.log('Autenticado, permitiendo acceso...');
    return next();
  }

  next();
});

export default router;
