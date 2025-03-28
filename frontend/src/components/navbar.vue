<template>
  <div class="container-fluid" style="background-color: #050517;">
    <nav class="container navbar navbar-expand-lg navbar-dark">
   
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav flex-wrap">
          <li class="nav-item">
            <router-link class="nav-link text-white" to="/">Inicio</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '1' } }">Comedia</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '2' } }">Conferencias</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '4' } }">Meetups</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '7' } }">Festivales</router-link>
          </li>

          <!-- Mostrar solo si el usuario es admin -->
          <li class="nav-item" v-if="isAdmin">
            <router-link class="nav-link text-white" to="/event-register">Crear Eventos</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import { isAdmin } from '@/services/authService';

export default {
  name: "Navbar",
  data() {
    return {
      isAdmin: false,
    };
  },
  mounted() {
    window.addEventListener("auth-changed", this.syncAdminState);
    this.isAdmin = isAdmin();
  },
  beforeUnmount() {
    window.removeEventListener("auth-changed", this.syncAdminState);
  },
  methods: {
    syncAdminState() {
      this.isAdmin = isAdmin();
    }
  }
};
</script>

<style scoped>
.navbar {
  font-family: 'Kanit', sans-serif;
  margin-bottom: 10px;
  background-color: #050517;
  padding: 10px 0;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.navbar-nav {
  display: flex;
  flex-wrap: wrap; 
  justify-content: flex-start; 
  gap: 10px;  
}

.nav-item {
  font-size: 16px;
  font-weight: 500;
  white-space: nowrap; 
}

.nav-link {
  color: white !important;
  padding: 10px 15px;
  text-transform: uppercase;
  transition: all 0.3s ease-in-out;
}

.nav-link:hover {
  background-color: #ffe900;
  color: #fff;
  border-radius: 20px;
}

.navbar-toggler {
  border-color: #fff;
}

.navbar-toggler-icon {
  background-image: url('data:image/svg+xml,%3csvg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"%3e%3cpath fill="%23fff" d="M0 4h30v2H0zm0 7h30v2H0zm0 7h30v2H0zm0 7h30v2H0z"%3e%3c/path%3e%3c/svg%3e');
}

@media (max-width: 768px) {
  .navbar-nav {
    width: 100%;
    justify-content: center; 
  }

  .nav-item {
    padding: 12px 20px;
    font-size: 18px;
  }

  .nav-link {
    padding: 12px 20px;
    font-size: 18px;
  }

  .container-fluid {
    padding-left: 0;
    padding-right: 0;
  }

  .navbar-collapse {
    display: block !important;
    padding-top: 10px;
  }
}
</style>
