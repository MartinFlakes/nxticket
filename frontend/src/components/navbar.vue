<template>
  <div class="container-fluid" style="background-color: #050517;">
    <nav class="container navbar navbar-expand-lg">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
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
          <li class="nav-item" v-if="isAdmin()">
            <router-link class="nav-link text-white" to="/event-register">Crear Eventos</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import { isAdmin } from '@/services/authService';  // Asegúrate de importar la función isAdmin

export default {
  name: "Navbar",
  methods: {
    isAdmin() {
      return isAdmin();  // Llamamos a la función que determina si el usuario es admin
    }
  }
};
</script>

<style scoped>
.navbar {
  margin-bottom: 20px;
}
</style>
