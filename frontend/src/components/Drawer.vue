<template>
    <div v-if="isOpen" class="drawer-overlay" @click="closeDrawer">
      <div class="drawer-content" :style="drawerStyles">
        <div class="drawer-header">
          <h3>Mi Cuenta</h3>
          <button class="close-btn" @click="closeDrawer">&times;</button>
        </div>
        <div class="drawer-body">
          <ul>
            <li><a href="/account">Ver mi cuenta</a></li>
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
        this.$emit("logout");
        this.closeDrawer();
      }
    }
  };
  </script>
  
  <style scoped>
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
    background: rgba(0, 0, 0, 0.4); /* Fondo oscuro con opacidad */
  }
  
  .drawer-content {
    width: 40%;
    height: 100%;
    background-color: white;
    padding: 20px;
    box-shadow: -4px 0px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
  }
  
  .drawer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .close-btn {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
  }
  
  .drawer-body {
    margin-top: 20px;
  }
  
  .drawer-body ul {
    list-style: none;
    padding: 0;
  }
  
  .drawer-body li {
    margin-bottom: 10px;
  }
  
  .drawer-body a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
  }
  </style>
  