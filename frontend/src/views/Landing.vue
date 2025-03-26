<template>
  <main class="landing-main">
    <header class="landing-header">
      <h1>Bienvenido a NxTicket</h1>
      <p class="subtitle">Descubre conferencias y eventos exclusivos.</p>
      <div class="buttons">
        <router-link to="/login" class="btn btn-login">Iniciar Sesión</router-link>
        <router-link to="/login?signup=true" class="btn btn-register">Registrarse</router-link>
      </div>
    </header>

    <section class="conferences-grid">
      <div v-for="event in eventsData.data" :key="event.id" 
           :class="['conference-item', event.size]">
        <img :src="event.imag" :alt="event.title" class="conference-image">
        <div class="conference-details">
          <h3>{{ event.title }}</h3>
          <div class="conf-date">{{ formatDate(event.start_date) }} -  {{formatDate(event.end_date) }}</div>
          <p>{{ event.description }}</p>
          <!-- <p><strong>Categoría:</strong> {{ event.categories.name }}</p> -->
          <p><strong>Organizador:</strong> {{ event.owner.name }}</p>
          <p>
            <strong>Anfitriones:</strong>
            <span v-for="(host, index) in event.hosts" :key="host.id">
              {{ host.name }}<span v-if="index < event.hosts.length - 1">, </span>
            </span>
          </p>
          <router-link to="/login" class="conf-btn">Inscribirse</router-link>
        </div>
      </div>
    </section>

    <!-- Paginación -->
    <div class="pagination">
      <!-- Botón de Anterior -->
      <button 
        v-if="eventsData.prev_page_url" 
        @click="fetchEvents(eventsData.prev_page_url)"
        class="btn-pagination">Anterior</button>
      
      <!-- Mostrar el número de página actual -->
      <span>{{ eventsData.current_page }} de {{ eventsData.last_page }}</span>
      
      <!-- Botón de Siguiente -->
      <button 
        v-if="eventsData.next_page_url" 
        @click="fetchEvents(eventsData.next_page_url)"
        class="btn-pagination">Siguiente</button>
    </div>
  </main>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const eventsData = ref([
  { 
    id: 1, 
    nombre: "Conferencia de Tecnología", 
    fecha: "2025-06-15", 
    descripcion: "Explora las últimas tendencias en tecnología e innovación.",
    imagen: "https://picsum.photos/seed/picsum/200/300",
    size: "large"
  },
  { 
    id: 2, 
    nombre: "Meetup de Innovación", 
    fecha: "2025-06-20", 
    descripcion: "Únete a la comunidad de innovadores y descubre nuevas ideas.",
    imagen: "https://picsum.photos/seed/picsum/200/300",
    size: "medium"
  },
  { 
    id: 3, 
    nombre: "Foro de Emprendimiento", 
    fecha: "2025-07-05", 
    descripcion: "Consejos y networking para emprendedores.",
    imagen: "https://picsum.photos/seed/picsum/200/300",
    size: "small"
  },
  { 
    id: 4, 
    nombre: "Tendencias en IA", 
    fecha: "2025-08-10", 
    descripcion: "Descubre el impacto de la inteligencia artificial en la industria.",
    imagen: "https://picsum.photos/seed/picsum/200/300",
    size: "large"
  },
  { 
    id: 5, 
    nombre: "Marketing Digital 2025", 
    fecha: "2025-09-01", 
    descripcion: "Estrategias innovadoras para el mundo digital.",
    imagen: "https://picsum.photos/seed/picsum/200/300",
    size: "medium"
  }
};

// Formatear fecha
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString("es-ES", { year: 'numeric', month: 'long', day: 'numeric' });
};

// Llamada inicial para cargar los eventos
fetchEvents();
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

.landing-main {
  text-align: center;
  padding: 2rem;
  min-height: 100vh;
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  font-family: 'Kanit', sans-serif;
}

.landing-header {
  padding: 4rem 2rem;
  text-align: center;
}

.landing-header h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
  font-weight: bold;
  color: #ffe900;
}

.landing-header .subtitle {
  font-size: 1.25rem;
  color: #ccc;
  margin-bottom: 2rem;
  font-family: 'Hiragino Sans', sans-serif;
}

.buttons {
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.btn {
  display: inline-block;
  padding: 0.8rem 1.5rem;
  border-radius: 5px;
  font-weight: bold;
  text-decoration: none;
  transition: all 0.3s ease;
  font-family: 'Kanit', sans-serif;
}

.btn-login {
  background: #ffe900;
  color: #050517;
}

.btn-login:hover {
  background: #e6d100;
  transform: translateY(-2px);
}

.btn-register {
  background: transparent;
  border: 2px solid #ffe900;
  color: #ffe900;
}

.btn-register:hover {
  background: #ffe900;
  color: #050517;
  transform: translateY(-2px);
}

.conferences-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1.5rem;
  padding: 2rem;
}

.conference-item {
  position: relative;
  overflow: hidden;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.conference-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.conference-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 10px 10px 0 0;
}

.conference-details {
  padding: 1.5rem;
  text-align: left;
}

.conference-details h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
  color: #ffe900;
  font-family: 'Kanit', sans-serif;
}

.conf-date {
  font-size: 0.9rem;
  color: #ccc;
  margin-bottom: 1rem;
  font-family: 'Hiragino Sans', sans-serif;
}

.conference-details p {
  font-size: 1rem;
  color: #ddd;
  margin-bottom: 1.5rem;
  font-family: 'Hiragino Sans', sans-serif;
}

.conf-btn {
  display: inline-block;
  background: #ffe900;
  padding: 0.5rem 1rem;
  text-decoration: none;
  font-weight: bold;
  color: #050517;
  border-radius: 5px;
  transition: background 0.3s ease;
  font-family: 'Kanit', sans-serif;
}

.conf-btn:hover {
  background: #e6d100;
}

.pagination {
  margin-top: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
}

.btn-pagination {
  background: #ffe900;
  padding: 0.6rem 1.5rem;
  border-radius: 5px;
  color: #050517;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
}

.btn-pagination:hover {
  background: #e6d100;
  transform: translateY(-2px);
}

@media (max-width: 768px) {
  .conferences-grid {
    grid-template-columns: 1fr;
  }

  .landing-header h1 {
    font-size: 2rem;
  }

  .landing-header .subtitle {
    font-size: 1rem;
  }

  .btn {
    padding: 0.6rem 1rem;
    font-size: 0.9rem;
  }
}
</style>
