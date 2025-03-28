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
              <span class="event-title">{{ event.nombre }} - {{ event.fecha }}</span>
              <p class="event-details">Ubicación: {{ event.ubicacion }} | Hora: {{ event.hora }}</p>
            </div>
            <button @click="viewDetails(event)">Ver Detalles</button>
          </li>
        </ul>
        <p v-else>No tienes inscripciones activas.</p>
      </div>
    </section>

    <div v-if="selectedEvent" class="modal" @click.self="closeModal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>{{ selectedEvent.nombre }}</h2>
        <p>Fecha: {{ selectedEvent.fecha }}</p>
        <p>Ubicación: {{ selectedEvent.ubicacion }}</p>
        <p>Hora: {{ selectedEvent.hora }}</p>
        <p>Descripción: {{ selectedEvent.descripcion }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        firstName: "John",
        lastName: "Doe",
        email: "john.doe@example.com",
      },
      subscriptions: [
        { id: 1, nombre: "Conferencia de Tecnología", fecha: "2025-06-15", ubicacion: "Centro de Convenciones", hora: "10:00 AM", descripcion: "Una conferencia sobre las últimas tendencias en tecnología." },
        { id: 2, nombre: "Meetup de Innovación", fecha: "2025-06-20", ubicacion: "Auditorio Principal", hora: "2:00 PM", descripcion: "Un meetup para discutir ideas innovadoras y proyectos." },
      ],
      selectedEvent: null,
    };
  },
  methods: {
    viewDetails(event) {
      this.selectedEvent = event;
    },
    closeModal() {
      this.selectedEvent = null;
    },
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