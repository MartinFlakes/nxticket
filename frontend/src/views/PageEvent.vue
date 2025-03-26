<template>
  <div class="conference-view">
    <div class="event-banner">
      <img :src="event.image" alt="Evento" class="event-image" />
    </div>
    
    <div class="event-content">
      <h1 class="event-title">{{ event.nombre }}</h1>
      <p class="event-description">{{ event.descripcion }}</p>
      
      <div class="event-info">
        <div class="info-item"><strong>Fecha:</strong> {{ event.fecha }}</div>
        <div class="info-item"><strong>Ubicación:</strong> {{ event.ubicacion }}</div>
        <div class="info-item"><strong>Espacio:</strong> {{ event.espacio }}</div>
        <div class="info-item"><strong>Horario:</strong> {{ event.horario }}</div>
      </div>
      
      <div class="event-actions">
        <button class="ticket-btn" @click="buyTicket">Comprar boletos</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ConferenceView',
  data() {
    return {
      event: {
        id: 1,
        nombre: "Conferencia de Tecnología",
        fecha: "2025-06-15",
        descripcion: "Explora las últimas tendencias en tecnología e innovación. Únete a expertos y líderes de la industria para conocer el futuro de la tecnología.",
        espacio: "Auditorio Central",
        ubicacion: "Ciudad de México",
        horario: "09:00 - 17:00",
        image: "https://picsum.photos/seed/picsum/200/300"
      }
    };
  },
  methods: {
    buyTicket() {
      alert(`Has comprado boletos para: ${this.event.nombre}`);
    }
  }
};
</script>

<style scoped>
.conference-view {
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  padding: 2rem;
  min-height: 100vh;
  font-family: 'Kanit', sans-serif;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.event-banner {
  width: 100%;
  max-width: 600px;
  margin-bottom: 1.5rem;
}

.event-image {
  width: 100%;
  border-radius: 10px;
  box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.2);
}

.event-content {
  max-width: 600px;
}

.event-title {
  font-size: 2.5rem;
  color: #ffe900;
}

.event-description {
  font-size: 1.2rem;
  color: #ccc;
  margin-top: 0.5rem;
}

.event-info {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin: 2rem 0;
  font-size: 1.1rem;
}

.info-item {
  background: rgba(255, 255, 255, 0.1);
  padding: 1rem;
  border-radius: 8px;
}

.event-actions {
  margin-top: 2rem;
}

.ticket-btn {
  background: #ffe900;
  color: #050517;
  border: none;
  padding: 0.75rem 1.5rem;
  font-size: 1.2rem;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.ticket-btn:hover {
  background: #e6d100;
}

@media (max-width: 768px) {
  .event-title {
    font-size: 2rem;
  }
  .event-info {
    font-size: 1rem;
  }
}
</style>