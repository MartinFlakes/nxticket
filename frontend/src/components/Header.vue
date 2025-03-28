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
.header {
    color: #fff;
    padding: 0.5rem;
    background-color: #01569a;
    
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 1rem;
}

.navbar-items {
    display: flex;
    gap: 1rem;
}

.navbar-item {
    color: #fff;
    padding: 0.5rem;
    font-family: 'Kanit', sans-serif;
    text-decoration: none;


}

.navbar-item:hover {
    text-decoration: underline;
}

.image-logo {
    width: 100px;
}

.logout {
    cursor: pointer;
    color: #ffe900;
    font-family: 'Kanit', sans-serif;

}
</style>
