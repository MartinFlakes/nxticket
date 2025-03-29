<template>
  <header class="header">
    <nav class="navbar">
      <div class="navbar-brand">
        <a class="navbar-item" href="/">
          <img src="@/assets/images/logonxticket.png" alt="Event Image" class="image-logo" />
        </a>
      </div>
      <div class="navbar-menu">
        <div class="navbar-items">
          <a v-if="!isLoggedIn" class="navbar-item" href="/login">Iniciar Sesión</a>
          <a v-else class="navbar-item" href="#" @click.prevent="toggleDrawer">Mi Cuenta</a>
          <a v-if="isLoggedIn" class="navbar-item logout" @click="logout">Cerrar Sesión</a>
        </div>
      </div>
    </nav>
    <Drawer ref="drawer" @logout="logout"/>
  </header>
</template>

<script>
import { isAuthenticated, logoutUser } from '@/services/authService';
import Drawer from '@/components/Drawer.vue';

export default {
  components: {
    Drawer
  },
  data() {
    return {
      isLoggedIn: isAuthenticated(),
    };
  },
  mounted() {
    window.addEventListener("auth-changed", this.syncAuthState);
  },
  beforeUnmount() {
    window.removeEventListener("auth-changed", this.syncAuthState);
  },
  methods: {
    syncAuthState() {
      this.isLoggedIn = isAuthenticated();
    },
    toggleDrawer() {
      this.$refs.drawer.openDrawer();
    },
    logout() {
      logoutUser();
      localStorage.clear();
      sessionStorage.clear();
      this.isLoggedIn = false;
      this.$router.push('/login');
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Header */
.header {
  color: #ffffff;
  padding: 0.5rem;
  background: linear-gradient(135deg, #01569a, #024077); /* #01569a como principal */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  font-family: 'Kanit', sans-serif;
}

/* Navbar dentro del Header */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 2rem;
  max-width: 1200px;
  margin: 0 auto;
  position: relative;
}

/* Marca */
.navbar-brand {
  display: flex;
  align-items: center;
}

.navbar-item {
  color: #ffffff;
  padding: 0.75rem 1.5rem;
  text-decoration: none;
  font-size: 1.2rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease;
  position: relative;
}

.image-logo {
  width: 120px;
  transition: transform 0.3s ease;
}

.navbar-brand .navbar-item:hover .image-logo {
  transform: scale(1.1); /* Zoom sutil al hover */
}

/* Menú */
.navbar-menu {
  display: flex;
  align-items: center;
}

.navbar-items {
  display: flex;
  gap: 1.5rem;
}

/* Ítems del Menú */
.navbar-item:not(.logout) {
  border-radius: 12px;
}

.navbar-item:not(.logout)::after {
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

.navbar-item:not(.logout):hover::after {
  width: 80%; /* Línea se expande al hover */
}

.navbar-item:not(.logout):hover {
  background: rgba(255, 233, 0, 0.2); /* Fondo amarillo tenue */
  color: #ffe900; /* Amarillo al hover */
}

/* Logout */
.logout {
  color: #ffe900; /* Amarillo como acento */
  position: relative;
  padding: 0.75rem 1.5rem;
  transition: all 0.3s ease;
}

.logout::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255, 233, 0, 0.3); /* Ripple con #ffe900 */
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s ease, height 0.6s ease;
}

.logout:hover::before {
  width: 200px;
  height: 200px;
}

.logout:hover {
  color: #ffffff;
  background: rgba(5, 5, 23, 0.5); /* Fondo oscuro al hover */
  border-radius: 12px;
}

/* Responsividad */
@media (max-width: 768px) {
  .navbar {
    padding: 0.5rem 1rem;
    flex-direction: column;
    align-items: flex-start;
  }

  .navbar-items {
    flex-direction: column;
    gap: 1rem;
    width: 100%;
    padding-top: 1rem;
  }

  .navbar-item {
    font-size: 1rem;
    padding: 0.6rem 1rem;
  }

  .image-logo {
    width: 100px;
  }
}
</style>