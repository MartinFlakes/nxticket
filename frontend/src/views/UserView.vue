<template>
  <div class="user-view">
    <header class="user-header">
      <h1>Bienvenido, {{ user.firstName }} {{ user.lastName }}</h1>
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
            <button @click="fetchEventDetails(event.id)">Ver Detalles</button>
          </li>
        </ul>
        <p v-else>No tienes inscripciones activas.</p>
      </div>
    </section>

    <!-- Modal para mostrar detalles del evento -->
    <div v-if="selectedEvent" class="modal" @click.self="closeModal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
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
      user: {
        id: null, // ID del usuario obtenido del token
        firstName: "John",
        lastName: "Doe",
        email: "john.doe@example.com",
      },
      subscriptions: [], // Lista de eventos a los que el usuario está inscrito
      selectedEvent: null, // Detalles del evento seleccionado
    };
  },
  methods: {
    // Obtener el ID del usuario desde el token almacenado en localStorage
    getUserIdFromToken() {
      console.log("Intentando obtener el ID del usuario desde localStorage...");
      const token = localStorage.getItem("access_token");
      if (!token) {
        console.error("No se encontró el token en localStorage.");
        return null;
      }

      try {
        const user = JSON.parse(localStorage.getItem("user"));
        console.log("Usuario obtenido desde localStorage:", user);
        return user?.id || null;
      } catch (error) {
        console.error("Error al parsear el usuario desde localStorage:", error);
        return null;
      }
    },

    // Obtener las inscripciones del usuario desde la API
    async fetchSubscriptions() {
      console.log("Intentando obtener las inscripciones del usuario...");
      console.log("ID del usuario:", this.user.id);

      if (!this.user.id) {
        console.error("El ID del usuario es nulo. No se puede continuar.");
        return;
      }

      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/events/myevents/${this.user.id}`);
        console.log("Respuesta de la API para las inscripciones:", response.data);
        this.subscriptions = response.data.data || response.data; // Adaptado al formato esperado
      } catch (error) {
        console.error("Error al obtener las inscripciones:", error.response?.data || error.message);
        this.subscriptions = []; // Limpia las inscripciones si hay un error
      }
    },

    // Obtener los detalles de un evento específico
    async fetchEventDetails(eventId) {
      console.log("Intentando obtener los detalles del evento con ID:", eventId);

      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/events/${eventId}`);
        console.log("Detalles del evento obtenidos:", response.data);
        this.selectedEvent = response.data;
      } catch (error) {
        console.error("Error al obtener los detalles del evento:", error.response?.data || error.message);
      }
    },

    // Cerrar el modal
    closeModal() {
      console.log("Cerrando el modal...");
      this.selectedEvent = null;
    },

    // Formatear fecha
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString("es-ES", { year: "numeric", month: "long", day: "numeric" });
    },

    // Formatear hora
    formatTime(dateString) {
      const date = new Date(dateString);
      return date.toLocaleTimeString("es-ES", { hour: "2-digit", minute: "2-digit" });
    },
  },
  mounted() {
    console.log("Componente montado. Intentando obtener el ID del usuario...");
    this.user.id = this.getUserIdFromToken();

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
.user-view {
  padding: 2rem;
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  font-family: 'Kanit', sans-serif;
  min-height: 100vh;
}

.user-header {
  text-align: center;
  margin-bottom: 2rem;
}

.user-header h1 {
  font-size: 2.5rem;
  color: #ffe900;
}

.user-header p {
  font-size: 1.25rem;
  color: #ccc;
}

.user-content {
  display: flex;
  justify-content: center;
  padding: 1rem;
}

.user-subscriptions {
  flex: 1;
  background: rgba(255, 255, 255, 0.1);
  padding: 1.5rem;
  border-radius: 10px;
}

h2 {
  font-size: 1.75rem;
  color: #ffe900;
  margin-bottom: 1rem;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  background: rgba(255, 255, 255, 0.1);
  padding: 0.75rem;
  margin-bottom: 0.5rem;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.event-info {
  flex: 1;
}

.event-title {
  font-weight: bold;
}

.event-details {
  font-size: 0.9rem;
  color: #ccc;
}

button {
  background: #ffe900;
  color: #050517;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #e6d100;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  width: 80%;
  max-width: 500px;
  text-align: center;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 1.5rem;
  cursor: pointer;
}

@media (max-width: 768px) {
  .user-content {
    flex-direction: column;
  }
}
</style>