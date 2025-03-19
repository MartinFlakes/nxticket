
<template>
<div class="conference-view">
<header class="conference-header">
<h1>{{ conference.nombre }}</h1>
<p>{{ conference.descripcion }}</p>
</header>
 
    <section class="conference-info">
<div class="info-item">
<strong>Fecha:</strong> {{ conference.fecha }}
</div>
<div class="info-item">
<strong>Espacio:</strong> {{ conference.espacio }}
</div>
<div class="info-item">
<strong>Ubicación:</strong> {{ conference.ubicacion }}
</div>
<div class="info-item">
<strong>Horario:</strong> {{ conference.horario }}
</div>
</section>
 
    <div class="conference-actions">
<button class="subscribe-btn" @click="subscribe">Inscribirse</button>
</div>
</div>
</template>
 
<script>
export default {
  name: 'ConferenceView',
  data() {
    return {
      conference: {
        id: 1,
        nombre: "Conferencia de Tecnología",
        fecha: "2025-06-15",
        descripcion: "Explora las últimas tendencias en tecnología e innovación. Únete a expertos y líderes de la industria para conocer el futuro de la tecnología.",
        espacio: "Auditorio Central",
        ubicacion: "Ciudad de México",
        horario: "09:00 - 17:00"
      }
    };
  },
  methods: {
    subscribe() {
      alert(`Te has inscrito a: ${this.conference.nombre}`);
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
}
 
.conference-header {
  text-align: center;
  margin-bottom: 2rem;
}
 
.conference-header h1 {
  font-size: 2.5rem;
  color: #ffe900;
}
 
.conference-header p {
  font-size: 1.2rem;
  color: #ccc;
  margin-top: 0.5rem;
}
 
.conference-info {
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
 
.conference-actions {
  text-align: center;
  margin-top: 2rem;
}
 
.subscribe-btn {
  background: #ffe900;
  color: #050517;
  border: none;
  padding: 0.75rem 1.5rem;
  font-size: 1.2rem;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
}
 
.subscribe-btn:hover {
  background: #e6d100;
}
 
/* Responsividad */
@media (max-width: 768px) {
  .conference-info {
    font-size: 1rem;
  }
  .conference-header h1 {
    font-size: 2rem;
  }
}
</style>