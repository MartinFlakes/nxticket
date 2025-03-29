<template>
  <div class="user-view">
    <header class="user-header">
      <h1>Bienvenido, {{ user.name }}</h1>
      <p>Aquí puedes ver tus inscripciones.</p>
    </header>

    <section class="user-content">
      <div class="user-subscriptions">
        <h2>Tus Inscripciones</h2>
        <ul v-if="subscriptions.length > 0">
          <li v-for="event in subscriptions" :key="event.id">
            <div class="event-info">
              <span class="event-title">{{ event.title }} - {{ formatDate(event.start_date) }}</span>
              <p class="event-details">Ubicación: {{ event.venue?.name || 'No especificada' }} | Hora: {{ formatTime(event.start_date) }}</p>
            </div>
            <button @click="fetchEventDetails(event.id)" class="btn-details">Ver Detalles</button>
          </li>
        </ul>
        <p v-else class="no-subscriptions">No tienes inscripciones activas.</p>
      </div>
    </section>

    <!-- Modal para mostrar detalles del evento -->
    <div v-if="selectedEvent" class="modal" @click.self="closeModal">
      <div class="modal-content">
        <span class="close" @click="closeModal">×</span>
        <h2>{{ selectedEvent.title }}</h2>
        <p>Fecha: {{ formatDate(selectedEvent.start_date) }}</p>
        <p>Ubicación: {{ selectedEvent.venue?.name || 'No especificada' }}</p>
        <p>Hora: {{ formatTime(selectedEvent.start_date) }}</p>
        <p>Descripción: {{ selectedEvent.description }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "UserView",
  data() {
    return {
      user: {},
      subscriptions: [],
      selectedEvent: null,
    };
  },
  methods: {
    async fetchUser() {
      console.log("Intentando obtener los datos del usuario autenticado...");
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/user", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        console.log("Datos del usuario obtenidos:", response.data);
        this.user = response.data;
      } catch (error) {
        console.error("Error al obtener los datos del usuario:", error.response?.data || error.message);
      }
    },

    async fetchSubscriptions() {
      console.log("Intentando obtener las inscripciones del usuario...");
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/user/myevents/${this.user.id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        console.log("Respuesta de la API para las inscripciones:", response.data);
        this.subscriptions = response.data.data || response.data;
      } catch (error) {
        console.error("Error al obtener las inscripciones:", error.response?.data || error.message);
        this.subscriptions = [];
      }
    },

    async fetchEventDetails(eventId) {
      console.log("Intentando obtener los detalles del evento con ID:", eventId);
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/events/${eventId}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        console.log("Detalles del evento obtenidos:", response.data);
        this.selectedEvent = response.data;
      } catch (error) {
        console.error("Error al obtener los detalles del evento:", error.response?.data || error.message);
      }
    },

    closeModal() {
      console.log("Cerrando el modal...");
      this.selectedEvent = null;
    },

    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString("es-ES", { year: "numeric", month: "long", day: "numeric" });
    },

    formatTime(dateString) {
      const date = new Date(dateString);
      return date.toLocaleTimeString("es-ES", { hour: "2-digit", minute: "2-digit" });
    },
  },
  async mounted() {
    console.log("Componente montado. Intentando obtener los datos del usuario...");
    await this.fetchUser();

    if (this.user.id) {
      console.log("ID del usuario obtenido:", this.user.id);
      console.log("Intentando obtener las inscripciones del usuario...");
      this.fetchSubscriptions();
    } else {
      console.error("No se pudo obtener el ID del usuario.");
    }
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Contenedor Principal */
.user-view {
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
.user-view::before {
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
.user-header {
  text-align: center;
  margin-bottom: 3rem;
  position: relative;
  z-index: 1;
}

.user-header h1 {
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

.user-header p {
  font-size: 1.5rem;
  color: #ccc;
  font-family: 'Hiragino Sans', sans-serif;
  font-style: italic;
}

/* Contenido */
.user-content {
  display: flex;
  justify-content: center;
  padding: 1rem;
  position: relative;
  z-index: 1;
}

.user-subscriptions {
  flex: 1;
  max-width: 800px;
  background: rgba(1, 86, 154, 0.9); /* #01569a como base */
  padding: 2rem;
  border-radius: 16px;
  border: 2px solid #ffe900; /* Borde amarillo */
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4), inset 0 0 10px rgba(255, 233, 0, 0.2);
}

.user-subscriptions h2 {
  font-size: 2rem;
  color: #ffe900; /* Amarillo como acento */
  margin-bottom: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
}

/* Lista de Inscripciones */
ul {
  list-style: none;
  padding: 0;
}

li {
  background: rgba(5, 5, 23, 0.3); /* #050517 como fondo secundario */
  padding: 1rem;
  margin-bottom: 1rem;
  border-radius: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid rgba(255, 233, 0, 0.3); /* Borde tenue amarillo */
}

li:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(255, 233, 0, 0.4); /* Sombra amarilla */
}

.event-info {
  flex: 1;
}

.event-title {
  font-weight: 600;
  font-size: 1.3rem;
  color: #ffe900; /* Amarillo */
}

.event-details {
  font-size: 1rem;
  color: #ddd;
  font-family: 'Hiragino Sans', sans-serif;
}

/* Botón de Detalles */
.btn-details {
  background: #01569a; /* #01569a como principal */
  color: #ffffff;
  border: 2px solid #ffe900; /* Borde amarillo */
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: 'Kanit', sans-serif;
  text-transform: uppercase;
  letter-spacing: 1px;
  position: relative;
  overflow: hidden;
}

.btn-details::before {
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

.btn-details:hover::before {
  width: 200px;
  height: 200px;
}

.btn-details:hover {
  background: #024077; /* Tono más oscuro de #01569a */
  color: #ffe900;
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5);
}

/* Mensaje de No Inscripciones */
.no-subscriptions {
  font-size: 1.5rem;
  color: #ffe900; /* Amarillo */
  text-align: center;
  margin: 2rem 0;
  font-family: 'Kanit', sans-serif;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
  animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* Modal */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: rgba(1, 86, 154, 0.95); /* #01569a como base */
  padding: 2rem;
  border-radius: 16px;
  width: 90%;
  max-width: 500px;
  text-align: center;
  color: #ffffff;
  border: 2px solid #ffe900; /* Borde amarillo */
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
  position: relative;
  animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
  0% { transform: translateY(-50px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}

.modal-content h2 {
  font-size: 2rem;
  color: #ffe900; /* Amarillo */
  margin-bottom: 1rem;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
}

.modal-content p {
  font-size: 1.1rem;
  color: #ddd;
  margin-bottom: 1rem;
  font-family: 'Hiragino Sans', sans-serif;
}

.close {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 2rem;
  color: #ffe900; /* Amarillo */
  cursor: pointer;
  transition: transform 0.3s ease;
}

.close:hover {
  transform: rotate(90deg); /* Rotación al hover */
}

/* Responsividad */
@media (max-width: 768px) {
  .user-view {
    padding: 1rem;
    margin-top: 140px; /* Ajuste para móviles */
  }

  .user-header h1 {
    font-size: 2rem;
  }

  .user-header p {
    font-size: 1.2rem;
  }

  .user-subscriptions {
    padding: 1.5rem;
  }

  .user-subscriptions h2 {
    font-size: 1.5rem;
  }

  li {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .btn-details {
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
  }

  .modal-content {
    width: 95%;
    padding: 1.5rem;
  }
}
</style>