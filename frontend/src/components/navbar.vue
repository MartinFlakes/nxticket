<template>
  <div class="container-fluid">
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
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Contenedor Principal */
.container-fluid {
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  padding: 0;
  position: relative;
  overflow: hidden;
  margin-top: 80px; /* Espacio para el header fijo */
}

/* Fondo decorativo */
.container-fluid::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(1, 86, 154, 0.3), transparent 70%); /* #01569a tenue */
  animation: pulse 15s infinite ease-in-out;
  z-index: 0;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.5; }
  50% { transform: scale(1.1); opacity: 0.8; }
}

/* Navbar */
.navbar {
  font-family: 'Kanit', sans-serif;
  padding: 1rem 2rem;
  background: rgba(1, 86, 154, 0.9); /* #01569a como base */
  border-radius: 16px;
  margin: 1rem auto;
  max-width: 1200px;
  position: relative;
  z-index: 1;
  border: 2px solid #ffe900; /* Borde amarillo como acento */
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4), inset 0 0 10px rgba(255, 233, 0, 0.2);
}

/* Lista de Navegación */
.navbar-nav {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1.5rem;
  width: 100%;
}

/* Ítems de Navegación */
.nav-item {
  font-size: 1.1rem;
  font-weight: 500;
}

/* Enlaces */
.nav-link {
  color: #ffffff !important;
  padding: 0.75rem 1.5rem;
  text-transform: uppercase;
  text-decoration: none;
  letter-spacing: 1px;
  transition: all 0.3s ease;
  position: relative;
  border-radius: 20px;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background: #ffe900; /* Línea amarilla como acento */
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.nav-link:hover::after {
  width: 80%; /* Línea se expande al hover */
}

.nav-link:hover {
  background: rgba(255, 233, 0, 0.2); /* Fondo amarillo tenue */
  color: #ffe900 !important; /* Amarillo al hover */
  transform: translateY(-2px); /* Leve elevación */
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5); /* Sombra amarilla */
}

/* Enlace Activo */
.router-link-active {
  background: rgba(255, 233, 0, 0.3);
  color: #ffe900 !important;
  box-shadow: 0 0 12px rgba(255, 233, 0, 0.7);
}

/* Toggler para móviles */
.navbar-toggler {
  border: 2px solid #ffe900;
}

.navbar-toggler-icon {
  background-image: url('data:image/svg+xml,%3csvg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"%3e%3cpath fill="%23ffe900" d="M0 4h30v2H0zm0 7h30v2H0zm0 7h30v2H0zm0 7h30v2H0z"%3e%3c/path%3e%3c/svg%3e');
}

/* Responsividad */
@media (max-width: 768px) {
  .navbar {
    padding: 1rem;
    margin: 0.5rem;
  }

  .navbar-nav {
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
  }

  .nav-item {
    font-size: 1rem;
  }

  .nav-link {
    padding: 0.75rem 1rem;
    font-size: 1rem;
  }

  .container-fluid {
    margin-top: 70px; /* Ajuste para móviles */
  }
}
</style>