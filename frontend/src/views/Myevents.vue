<template>
  <div class="events-container">
    <div v-if="events.length === 0" class="no-events-message">
      <p>No tienes eventos registrados.</p>
    </div>
    <div v-for="event in events" :key="event.id" class="conference-card">
      <div class="event-image-container">
        <img :src="event.image_url" alt="Evento" class="event-image" />
      </div>
      <div class="event-content">
        <h2 class="event-title">{{ event.title }}</h2>
        <p class="event-description">{{ event.description || 'Sin descripción disponible' }}</p>
        <div class="event-info">
          <p><strong>Fecha:</strong> {{ formatFecha(event.start_date) }} - {{ formatFecha(event.end_date) }}</p>
          <p><strong>Categoría:</strong> {{ event.categories.name }}</p>
        </div>
        <div class="event-actions">
          <button class="edit-btn"><i class="fas fa-edit"></i> Editar</button>
          <button class="delete-btn" @click="deleteEvent(event.id)"><i class="fas fa-trash-alt"></i> Eliminar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      events: [],
    };
  },
  methods: {
    async fetchEvents() {
      try {
        const userId = localStorage.getItem('user_id');
        if (!userId) {
          console.error('No se encontró user_id en el localStorage.');
          return;
        }
        const response = await axios.get(`http://127.0.0.1:8000/api/events/myevents/${userId}`);
        this.events = response.data.data;
      } catch (error) {
        console.error('Error al obtener eventos:', error);
      }
    },
    formatFecha(fecha) {
      const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(fecha).toLocaleDateString('es-ES', opciones);
    },
    deleteEvent(eventId) {
      console.log(`Eliminar evento con ID: ${eventId}`);
    }
  },
  mounted() {
    this.fetchEvents();
  }
};
</script>

<style scoped>
.events-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
  gap: 2rem;
  padding: 2rem;
  justify-content: center;
  max-width: 1200px;
  margin: 0 auto;
}

.conference-card {
  display: flex;
  flex-direction: column; 
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  padding: 2rem;
  border-radius: 16px;
  box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}

.conference-card:hover {
  transform: scale(1.03);
}

.event-image-container {
  width: 100%;
  height: 200px;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 1rem;
}

.event-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.event-content {
  flex: 1;
}

.event-title {
  font-size: 2rem;
  color: #ffe900;
  margin-bottom: 1rem;
}

.event-description {
  font-size: 1.1rem;
  color: #ccc;
  margin-bottom: 1rem;
  line-height: 1.5;
}

.event-info p {
  font-size: 1rem;
  margin: 0.3rem 0;
  color: #bbb;
}

.event-actions {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  margin-top: 1rem;
}

.edit-btn, .delete-btn {
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  font-size: 1.1rem;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease;
  width: 48%; 
  display: flex;
  justify-content: center;
  align-items: center;
}

.edit-btn {
  display: inline-block;
  background: #01569a; 
  padding: 0.75rem 1.5rem;
  text-decoration: none;
  font-weight: 600;
  color: #ffffff;
  border: 2px solid #ffe900;
  border-radius: 8px;
  transition: all 0.3s ease;
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
}

.delete-btn {
  display: inline-block;
  background: #01569a; 
  padding: 0.75rem 1.5rem;
  text-decoration: none;
  font-weight: 600;
  color: #ffffff;
  border: 2px solid #fe4a49  ;
  border-radius: 8px;
  transition: all 0.3s ease;
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
}

.delete-btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(254, 74, 73, 0.3);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s ease, height 0.6s ease;
}

.delete-btn:hover::before {
  width: 200px;
  height: 200px;
}

.delete-btn:hover {
  background: #024077; 
  color: #fe4a49  ;
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5);
}



.edit-btn {
  display: inline-block;
  background: #01569a; 
  padding: 0.75rem 1.5rem;
  text-decoration: none;
  font-weight: 600;
  color: #ffffff;
  border: 2px solid #ffe900;
  border-radius: 8px;
  transition: all 0.3s ease;
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
}

.edit-btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255, 233, 0, 0.3);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s ease, height 0.6s ease;
}

.edit-btn:hover::before {
  width: 200px;
  height: 200px;
}

.edit-btn:hover {
  background: #024077; 
  color: #ffe900;
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5);
}
</style>

