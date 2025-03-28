<template>
  <div v-if="isOpen" class="drawer-overlay" @click="closeDrawer">
    <div class="drawer-content" :style="drawerStyles" @click.stop>
      <div class="drawer-header">
        <h3 class="welcome-message">Mi Cuenta</h3>
        <button class="close-btn" @click="closeDrawer">×</button>
      </div>
      <div class="drawer-body">
        <p class="welcome-message">Bienvenido, {{ userName }}</p>
        <p class="user-role">{{ userRoleText }}</p>
        <ul>
          <li>
            <a href="/account">
              <span class="icon">👤</span> Ver mi cuenta
            </a>
          </li>
          <li v-if="isUser">
            <a href="/user">
              <span class="icon">🎟️</span> Tus inscripciones
            </a>
          </li>
          <li v-if="isAdmin">
            <a href="/myevents">
              <span class="icon">🎉</span> Tus eventos
            </a>
          </li>
          <li>
            <a href="#" @click="logout">
              <span class="icon">🚪</span> Cerrar sesión
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isOpen: false,
      drawerStyles: {
        transform: 'translateX(100%)',
        opacity: 0
      }
    };
  },
  computed: {
    userName() {
      return localStorage.getItem('name') || 'Invitado';
    },
    userRole() {
      return localStorage.getItem('role_id') || '';
    },
    userRoleText() {
      return this.userRole === '1' ? 'Cuenta de Administrador' : this.userRole === '2' ? 'Cuenta de Usuario' : 'Rol desconocido';
    },
    isAdmin() {
      return this.userRole === '1';
    },
    isUser() {
      return this.userRole === '2';
    }
  },
  methods: {
    openDrawer() {
      this.isOpen = true;
      this.animateDrawerOpen();
    },
    closeDrawer() {
      this.animateDrawerClose();
    },
    animateDrawerOpen() {
      setTimeout(() => {
        this.drawerStyles = {
          transform: 'translateX(0)',
          opacity: 1
        };
      }, 10);
    },
    animateDrawerClose() {
      this.drawerStyles = {
        transform: 'translateX(100%)',
        opacity: 0
      };
      setTimeout(() => {
        this.isOpen = false;
      }, 300);
    },
    logout() {
      localStorage.removeItem('name');
      localStorage.removeItem('role_id');
      this.$emit("logout");
      this.closeDrawer();
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Overlay */
.drawer-overlay {
  position: fixed;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  z-index: 1000;
  background: rgba(0, 0, 0, 0.7); /* Más oscuro para contraste */
  font-family: 'Kanit', sans-serif;
}

/* Contenido del Drawer */
.drawer-content {
  width: 350px;
  height: 100%;
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  padding: 20px;
  box-shadow: -8px 0 30px rgba(0, 0, 0, 0.5); /* Sombra más profunda */
  border-left: 3px solid #ffe900; /* Borde amarillo como acento */
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
  position: relative;
  overflow-y: auto; /* Scroll si el contenido es largo */
}

/* Header del Drawer */
.drawer-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  position: relative;
  z-index: 1;
}

.welcome-message {
  font-size: 1.8rem;
  font-weight: 600;
  color: #ffe900; /* Amarillo como acento */
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
  text-align: center;
}

.close-btn {
  background: none;
  border: none;
  font-size: 2rem;
  color: #ffe900; /* Amarillo */
  cursor: pointer;
  transition: transform 0.3s ease;
}

.close-btn:hover {
  transform: rotate(90deg); /* Rotación al hover */
}

/* Cuerpo del Drawer */
.drawer-body {
  margin-top: 20px;
  position: relative;
  z-index: 1;
}

.drawer-body .welcome-message {
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.user-role {
  font-size: 1.1rem;
  color: #ccc;
  margin-bottom: 20px;
  font-family: 'Hiragino Sans', sans-serif;
  text-align: center;
  font-style: italic;
}

/* Lista de Opciones */
.drawer-body ul {
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.drawer-body li {
  margin-bottom: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.drawer-body li:hover {
  transform: translateX(5px); /* Desplazamiento sutil al hover */
  box-shadow: 0 4px 10px rgba(255, 233, 0, 0.3); /* Sombra amarilla */
}

.drawer-body a {
  text-decoration: none;
  color: #ffffff;
  font-weight: 500;
  font-size: 1.2rem;
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  background: rgba(5, 5, 23, 0.3); /* #050517 como fondo secundario */
  transition: all 0.3s ease;
}

.drawer-body a:hover {
  background: rgba(255, 233, 0, 0.2); /* Fondo amarillo tenue */
  color: #ffe900; /* Amarillo al hover */
}

/* Iconos */
.icon {
  margin-right: 10px;
  font-size: 1.3rem;
}

/* Scrollbar estilizado */
.drawer-content::-webkit-scrollbar {
  width: 8px;
}

.drawer-content::-webkit-scrollbar-thumb {
  background: #ffe900; /* Amarillo */
  border-radius: 4px;
}

.drawer-content::-webkit-scrollbar-track {
  background: rgba(5, 5, 23, 0.5); /* Fondo oscuro */
}

/* Responsividad */
@media (max-width: 768px) {
  .drawer-content {
    width: 300px;
  }

  .welcome-message {
    font-size: 1.5rem;
  }

  .user-role {
    font-size: 1rem;
  }

  .drawer-body a {
    font-size: 1rem;
    padding: 0.6rem 0.8rem;
  }

  .icon {
    font-size: 1.1rem;
  }
}
</style>