import { createRouter, createWebHistory } from 'vue-router';
import LandingView from '@/views/Landing.vue';
import LoginView from '@/views/Login.vue';
import UserView from '@/views/UserView.vue';
import EventDetail from '@/components/Events/EventDetail.vue';
import HomeView from '../views/HomeView.vue';
import EventPage from'@/views/PageEvent.vue';
import Registerevent from '@/views/Registerevent.vue';
import Registerpageevent from '@/views/Registerpage.vue';
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

    },
    {
      path: '/myevents',
      name: 'myevents',
      component: Myevents,

    }
  ],
});

export default router;