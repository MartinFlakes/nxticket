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
import { isAuthenticated, isAdmin } from '@/services/authService';  // Importa correctamente las funciones

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

// ⚠️ Guardia global para verificar autenticación y rol antes de acceder a rutas protegidas
router.beforeEach((to, from, next) => {
  console.log(`Intentando acceder a: ${to.name}`);

  // Verificar si la ruta requiere autenticación
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Si no está autenticado, redirigir a login
    if (!isAuthenticated()) {
      console.log('No autenticado, redirigiendo al login...');
      return next({ name: 'login' });
    }

    // Si la ruta requiere permisos de administrador, y el usuario no es admin, redirigir
    if (to.matched.some(record => record.meta.requiresAdmin) && !isAdmin()) {
      console.log('Acceso denegado. Se requiere rol de administrador.');
      return next({ name: 'landing' }); // Redirigir a landing si no es admin
    }

    console.log('Autenticado, permitiendo acceso...');
    return next();  // Permitir acceso si todo es correcto
  }

  // Si la ruta no requiere autenticación, permitir acceso
  next();
});

export default router;
