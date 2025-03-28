<template>
  <div v-if="isOpen" class="drawer-overlay" @click="closeDrawer">
    <div class="drawer-content" :style="drawerStyles" @click.stop>
      <div class="drawer-header">
        <h3 class="welcome-message">Mi Cuenta</h3>
        <button class="close-btn" @click="closeDrawer">&times;</button>
      </div>
      <div class="drawer-body">
        <p class="welcome-message">Bienvenido, {{ userName }}</p>
        <p class="user-role">{{ userRoleText }}</p>
        <ul>
          <li><a href="/account">Ver mi cuenta</a></li>
          <li v-if="isUser"><a href="/user">Tus inscripciones</a></li>
          <li v-if="isAdmin"><a href="/myevents">Tus eventos</a></li>
          <li><a href="#" @click="logout">Cerrar sesión</a></li>
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
  .welcome-message {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
    text-align: center;
  }
  
  .user-role {
    font-size: 16px;
    color: #777;
    margin-bottom: 20px;
    text-align: center;
  }
  
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
    background: rgba(0, 0, 0, 0.5);
    font-family: 'Kanit', sans-serif;

  }
  
  .drawer-content {
    width: 350px;  
    height: 100%;
    background-color: #fff;
    padding: 20px;
    box-shadow: -4px 0px 30px rgba(0, 0, 0, 0.2); 
    border-radius: 8px; 
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
  }
  
  .drawer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .close-btn {
    background: none;
    border: none;
    font-size: 30px;
    color: #888;
    cursor: pointer;
  }
  
  .drawer-body {
    margin-top: 20px;
  }
  
  .drawer-body ul {
    list-style: none;
    padding: 0;
    margin-top: 10px;
  }
  
  .drawer-body li {
    margin-bottom: 12px;
  }
  
  .drawer-body a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: color 0.3s;
  }
  
  .drawer-body a:hover {
    color: #007bff; 
  }
  </style>
  