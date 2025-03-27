<template>
    <div v-if="isOpen" class="drawer-overlay" @click="closeDrawer">
      <div class="drawer-content" :style="drawerStyles">
        <div class="drawer-header">
          <h3 class="welcome-message">Mi Cuenta</h3>
          <button class="close-btn" @click="closeDrawer">&times;</button>
        </div>
        <div class="drawer-body">
          <p class="welcome-message">Bienvenido, {{ userName }}</p>
          <p class="user-role">{{ userRole }}</p>
          <ul>
            <li><a href="/account">Ver mi cuenta</a></li>
            <li><a href="/user">Tus inscripciones</a></li>
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
          transform: 'translateX(100%)',  // Inicia fuera de la pantalla
          opacity: 0
        }
      };
    },
    computed: {
      // Propiedad computada para el nombre del usuario
      userName() {
        return localStorage.getItem('name') || 'Invitado';
      },
      // Propiedad computada para el rol del usuario
      userRole() {
        const role = localStorage.getItem('role_id');
        if (role === '1') {
          return 'Cuenta de Administrador';
        } else if (role === '2') {
          return 'Cuenta de Usuario';
        }
        return 'Rol desconocido';
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
            transform: 'translateX(0)',  // Mover hacia la pantalla
            opacity: 1
          };
        }, 10);
      },
      animateDrawerClose() {
        this.drawerStyles = {
          transform: 'translateX(100%)',  // Mover fuera de la pantalla
          opacity: 0
        };
  
        // Cerrar después de la animación (se espera un poco para que el movimiento termine)
        setTimeout(() => {
          this.isOpen = false;
        }, 300); // Tiempo de la animación
      },
      logout() {
        // Borrar los datos del usuario en localStorage
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
    background: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad */
    font-family: 'Kanit', sans-serif;

  }
  
  .drawer-content {
    width: 350px;  /* Ancho ajustado para hacerlo más elegante */
    height: 100%;
    background-color: #fff;
    padding: 20px;
    box-shadow: -4px 0px 30px rgba(0, 0, 0, 0.2); /* Sombra más suave */
    border-radius: 8px;  /* Bordes redondeados */
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
    color: #007bff;  /* Color azul al pasar el mouse */
  }
  </style>
  