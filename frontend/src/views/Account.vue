<template>
  <div class="account-view">
    <header class="account-header">
      <h1>Mi Cuenta</h1>
    </header>

    <section class="account-content">
      <p v-if="loading" class="loading">Cargando...</p>
      <p v-if="error" class="error">{{ error }}</p>

      <div v-if="user" class="user-details">
        <h2>Bienvenido, {{ user.name }}!</h2>
        <p><strong>Correo Electrónico:</strong> {{ user.email }}</p>
        <p><strong>Rol:</strong> {{ userRole }}</p>
        <p><strong>Fecha de Verificación:</strong> {{ user.email_verified_at ? formatDate(user.email_verified_at) : 'No verificado' }}</p>
        <p><strong>Fecha de Creación:</strong> {{ formatDate(user.created_at) }}</p>
        <p><strong>Última Actualización:</strong> {{ formatDate(user.updated_at) }}</p>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      user: null,
      error: null,
      loading: true,
    };
  },
  computed: {
    userRole() {
      if (this.user?.role_id === 1) {
        return "Administrador";
      } else if (this.user?.role_id === 2) {
        return "Usuario";
      }
      return "Rol desconocido";
    },
  },
  mounted() {
    this.fetchUserData();
  },
  methods: {
    async fetchUserData() {
      console.log("Intentando obtener los datos del usuario...");
      try {
        const token = localStorage.getItem("access_token");
        if (!token) {
          this.error = "No se ha encontrado el token de autenticación.";
          this.loading = false;
          return;
        }

        const response = await axios.get("http://127.0.0.1:8000/api/user", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        console.log("Datos del usuario obtenidos:", response.data);
        this.user = response.data;
      } catch (error) {
        console.error("Error al obtener los datos del usuario:", error.response?.data || error.message);
        this.error = "Hubo un problema al obtener los datos de tu cuenta.";
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString("es-ES", { year: "numeric", month: "long", day: "numeric" });
    },
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Contenedor Principal */
.account-view {
  padding: 2rem;
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  color: #ffffff;
  font-family: 'Kanit', sans-serif;
  min-height: 100vh;
  position: relative;
  overflow: hidden;
  margin-top: 160px; /* Espacio para header y navbar fijos */
}

/* Fondo decorativo */
.account-view::before {
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

/* Header */
.account-header {
  text-align: center;
  margin-bottom: 3rem;
  position: relative;
  z-index: 1;
}

.account-header h1 {
  font-size: 3rem;
  color: #ffe900; /* Amarillo como acento */
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(1, 86, 154, 0.7), 0 0 20px rgba(255, 233, 0, 0.5);
  animation: glow 2s infinite alternate;
}

@keyframes glow {
  0% { text-shadow: 0 0 10px rgba(1, 86, 154, 0.7), 0 0 20px rgba(255, 233, 0, 0.5); }
  100% { text-shadow: 0 0 15px rgba(1, 86, 154, 0.9), 0 0 30px rgba(255, 233, 0, 0.7); }
}

/* Contenido */
.account-content {
  max-width: 600px;
  margin: 0 auto;
  background: rgba(1, 86, 154, 0.9); /* #01569a como base */
  padding: 2rem;
  border-radius: 16px;
  border: 2px solid #ffe900; /* Borde amarillo */
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4), inset 0 0 10px rgba(255, 233, 0, 0.2);
  position: relative;
  z-index: 1;
}

/* Mensaje de Carga */
.loading {
  text-align: center;
  font-size: 1.5rem;
  color: #ffe900; /* Amarillo */
  margin: 2rem 0;
  font-family: 'Kanit', sans-serif;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
  animation: fadeIn 1s ease-in-out infinite;
}

/* Mensaje de Error */
.error {
  text-align: center;
  font-size: 1.5rem;
  color: #fe4a49; /* Rojo para error */
  margin: 2rem 0;
  font-family: 'Kanit', sans-serif;
  text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
  animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* Detalles del Usuario */
.user-details {
  text-align: left;
  animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
  0% { transform: translateY(-20px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}

.user-details h2 {
  font-size: 2.2rem;
  color: #ffe900; /* Amarillo */
  margin-bottom: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
}

.user-details p {
  font-size: 1.2rem;
  margin: 1rem 0;
  color: #ddd;
  font-family: 'Hiragino Sans', sans-serif;
  padding: 0.5rem 0;
  border-bottom: 1px solid rgba(255, 233, 0, 0.2); /* Línea tenue amarilla */
  transition: color 0.3s ease;
}

.user-details p:hover {
  color: #ffffff; /* Resaltar al hover */
}

.user-details strong {
  color: #ffe900; /* Amarillo para etiquetas */
  font-weight: 500;
}

/* Responsividad */
@media (max-width: 768px) {
  .account-view {
    padding: 1rem;
    margin-top: 140px; /* Ajuste para móviles */
  }

  .account-header h1 {
    font-size: 2rem;
  }

  .account-content {
    padding: 1.5rem;
  }

  .user-details h2 {
    font-size: 1.8rem;
  }

  .user-details p {
    font-size: 1rem;
  }

  .loading, .error {
    font-size: 1.2rem;
    margin: 1.5rem 0;
  }
}
</style> 