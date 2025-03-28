<template>
    <div>
      <h1>Mi Cuenta</h1>
      <p v-if="loading">Cargando...</p>
      <p v-if="error" class="error">Hubo un error al cargar los detalles de tu cuenta. Por favor, intenta nuevamente.</p>
      <p v-if="user">
        Bienvenido a tu cuenta, {{ user.name }}!<br>
        Rol: {{ userRole }}
      </p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        user: null,   // Almacenar los detalles del usuario
        error: null,  // Almacenar cualquier error que ocurra durante la solicitud
        loading: true // Para mostrar un mensaje de carga mientras se obtienen los datos
      };
    },
    computed: {
      userRole() {
        const role = this.user?.role?.name || 'Rol desconocido'; // Accede al rol del usuario desde la API
        return role;
      }
    },
    mounted() {
      this.fetchUserData();
    },
    methods: {
      async fetchUserData() {
        try {
          const token = localStorage.getItem('access_token'); // Asegúrate de que el token esté almacenado correctamente
          if (!token) {
            this.error = "No se ha encontrado el token de autenticación.";
            this.loading = false;
            return;
          }
  
          const response = await axios.get('http://127.0.0.1:8000/api/user', {
            headers: {
              Authorization: `Bearer ${token}` // Enviar el token de autenticación en el header
            }
          });
  
          this.user = response.data; // Guardar los datos del usuario
        } catch (error) {
          this.error = "Hubo un problema al obtener los datos de tu cuenta."; // Mostrar mensaje de error si algo falla
        } finally {
          this.loading = false; // Desactivar el estado de carga
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Estilos para la página de cuenta */
  .error {
    color: red;
    text-align: center;
  }
  </style>
  