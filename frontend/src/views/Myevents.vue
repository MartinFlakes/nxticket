<template>
  <div class="events-container">
    <div v-for="event in events" :key="event.id" class="conference-card">
      <img :src="event.image" alt="Evento" class="event-image" />
      <div class="event-details">
        <h2 class="event-title">{{ event.nombre }}</h2>
        <p class="event-description">{{ event.descripcion || 'Sin descripción disponible' }}</p>
        <div class="event-info">
          <p><strong>Fecha:</strong> {{ formatFecha(event.fechaInicio) }} - {{ formatFecha(event.fechaFin) }}</p>
          <p><strong>Ubicación:</strong> {{ event.ciudad }}, {{ event.estado }}</p>
          <p><strong>Dirección:</strong> {{ event.direccion }}</p>
          <p><strong>Categoría:</strong> {{ event.categoria }}</p>
          <p><strong>Espacio:</strong> {{ event.lugar }} (Capacidad: {{ event.capacidad }})</p>
          <p><strong>Asientos Disponibles:</strong> {{ event.asientos }}</p>
          <p><strong>Filas:</strong> {{ event.filas }}</p>
          <p><strong>Precio:</strong> ${{ event.precio }}</p>
        </div>
        <div class="event-actions">
          <button class="edit-btn">Editar</button>
          <button class="delete-btn">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ConferenceCard',
  data() {
    return {
      events: [
        {
          id: 1,
          nombre: "Concierto de Rock",
          descripcion: "Un increíble concierto con las mejores bandas de rock.",
          fechaInicio: "2025-07-01",
          fechaFin: "2025-07-02",
          ciudad: "Ciudad de México",
          estado: "CDMX",
          direccion: "Av. Reforma 123",
          categoria: "Concierto",
          lugar: "Auditorio Nacional",
          capacidad: 5000,
          asientos: 1000,
          filas: 50,
          precio: 800,
          image: "https://picsum.photos/400/250"
        },
        {
          id: 2,
          nombre: "Feria del Libro",
          descripcion: "Un evento con la mejor literatura y escritores reconocidos.",
          fechaInicio: "2025-08-10",
          fechaFin: "2025-08-15",
          ciudad: "Guadalajara",
          estado: "Jalisco",
          direccion: "Expo Guadalajara",
          categoria: "Cultural",
          lugar: "Centro de Exposiciones",
          capacidad: 3000,
          asientos: 1200,
          filas: 60,
          precio: 200,
          image: "https://picsum.photos/400/251"
        },
        
      ]
    };
  },
  methods: {
    formatFecha(fecha) {
      const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(fecha).toLocaleDateString('es-ES', opciones);
    }
  }
};
</script>

<style scoped>
.events-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 1.5rem;
  justify-content: center;
  padding: 1.5rem;
}

.conference-card {
  display: flex;
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.2);
  align-items: center;
  gap: 1.5rem;
  max-width: 700px;
}

.event-image {
  width: 180px;
  height: 180px;
  border-radius: 10px;
  object-fit: cover;
}

.event-details {
  flex: 1;
}

.event-title {
  font-size: 1.8rem;
  color: #ffe900;
  margin-bottom: 0.5rem;
}

.event-description {
  font-size: 1rem;
  color: #ccc;
  margin-bottom: 1rem;
}

.event-info p {
  font-size: 1rem;
  margin: 0.3rem 0;
}

.event-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.8rem;
  margin-top: 1rem;
}

.edit-btn, .delete-btn {
  padding: 0.6rem 1.2rem;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  border: none;
}

.edit-btn {
  background: #ffe900;
  color: #050517;
}

.delete-btn {
  background: #d9534f;
  color: white;
}

.edit-btn:hover {
  background: #e6d100;
}

.delete-btn:hover {
  background: #c9302c;
}
</style>
