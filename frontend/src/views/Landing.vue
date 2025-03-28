<template>
  <main class="landing-main">
    <header class="landing-header">
      <h1>Bienvenido a NxTicket</h1>
      <p class="subtitle">Descubre conferencias y eventos exclusivos.</p>
      <div class="buttons">
        <!-- Mostrar solo si no hay token en el localStorage -->
        <router-link v-if="!isLoggedIn" to="/login" class="btn btn-login">Iniciar Sesión</router-link>
        <router-link v-if="!isLoggedIn" to="/login?signup=true" class="btn btn-register">Registrarse</router-link>
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

          <p>
            <strong>Anfitriones:</strong>
            <span v-for="(host, index) in event.hosts" :key="host.id">
              {{ host.name }}<span v-if="index < event.hosts.length - 1">, </span>
            </span>
          </p>
          <router-link v-if="isLoggedIn" to="/events/inscribe" class="conf-btn">Inscribirse</router-link>
          <router-link v-else to="/login" class="conf-btn">Iniciar sesión para inscribirse</router-link>
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

// Estado para almacenar los eventos y la paginación
const eventsData = ref({
  data: [],
  next_page_url: null,
  prev_page_url: null,
  current_page: 1,
  last_page: 1
});

// Verificar si el usuario está logueado (si existe el token)
const isLoggedIn = ref(localStorage.getItem("access_token") !== null);

// Función para obtener los eventos de la API
const fetchEvents = async (url = "http://127.0.0.1:8000/api/events?page=1") => {
  try {
    const response = await axios.get(url);
    eventsData.value = response.data;
  } catch (error) {
    console.error("Error fetching events:", error);
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

/* Contenedor Principal */
.landing-main {
  text-align: center;
  padding: 2rem;
  min-height: 100vh;
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  color: #ffffff;
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
  margin-top: 160px; /* Espacio para header y navbar fijos */
}

/* Fondo decorativo */
.landing-main::before {
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
.landing-header {
  padding: 4rem 2rem;
  text-align: center;
  position: relative;
  z-index: 1;
}

.landing-header h1 {
  font-size: 3.5rem;
  margin-bottom: 1rem;
  font-weight: 700;
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

.landing-header .subtitle {
  font-size: 1.5rem;
  color: #ccc;
  margin-bottom: 2.5rem;
  font-family: 'Hiragino Sans', sans-serif;
  font-style: italic;
}

/* Botones */
.buttons {
  display: flex;
  justify-content: center;
  gap: 1.5rem;
}

.btn {
  display: inline-block;
  padding: 1rem 2rem;
  border-radius: 12px;
  font-weight: 600;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease;
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
}

.btn-login {
  background: #01569a; /* #01569a como principal */
  color: #ffffff;
  border: 2px solid #ffe900; /* Borde amarillo */
}

.btn-login::before {
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

.btn-login:hover::before {
  width: 300px;
  height: 300px;
}

.btn-login:hover {
  background: #024077; /* Tono más oscuro de #01569a */
  color: #ffe900;
  transform: translateY(-3px);
  box-shadow: 0 0 15px rgba(255, 233, 0, 0.5);
}

.btn-register {
  background: transparent;
  border: 2px solid #ffe900;
  color: #ffe900;
}

.btn-register::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(1, 86, 154, 0.3); /* Ripple con #01569a */
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s ease, height 0.6s ease;
}

.btn-register:hover::before {
  width: 300px;
  height: 300px;
}

.btn-register:hover {
  background: #ffe900;
  color: #050517;
  transform: translateY(-3px);
  box-shadow: 0 0 15px rgba(1, 86, 154, 0.5);
}

/* Conferences Grid */
.conferences-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 2rem;
  padding: 2rem;
  position: relative;
  z-index: 1;
}

.conference-item {
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  background: rgba(1, 86, 154, 0.9); /* #01569a como base */
  border: 2px solid #ffe900; /* Borde amarillo */
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.conference-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(255, 233, 0, 0.5); /* Sombra amarilla */
}

.conference-image {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 14px 14px 0 0;
  transition: transform 0.3s ease;
}

.conference-item:hover .conference-image {
  transform: scale(1.05); /* Zoom sutil al hover */
}

.conference-details {
  padding: 1.5rem;
  text-align: left;
}

.conference-details h3 {
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
  color: #ffe900; /* Amarillo como acento */
  font-family: 'Kanit', sans-serif;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
}

.conf-date {
  font-size: 1rem;
  color: #ccc;
  margin-bottom: 1rem;
  font-family: 'Hiragino Sans', sans-serif;
}

.conference-details p {
  font-size: 1.1rem;
  color: #ddd;
  margin-bottom: 1.5rem;
  font-family: 'Hiragino Sans', sans-serif;
}

.conf-btn {
  display: inline-block;
  background: #01569a; /* #01569a como principal */
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

.conf-btn::before {
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

.conf-btn:hover::before {
  width: 200px;
  height: 200px;
}

.conf-btn:hover {
  background: #024077; /* Tono más oscuro de #01569a */
  color: #ffe900;
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5);
}

/* Paginación */
.pagination {
  margin: 3rem 0;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1.5rem;
  position: relative;
  z-index: 1;
}

.pagination span {
  font-size: 1.2rem;
  color: #ddd;
  font-family: 'Hiragino Sans', sans-serif;
}

.btn-pagination {
  background: #01569a; /* #01569a como principal */
  padding: 0.75rem 1.5rem;
  border: 2px solid #ffe900;
  border-radius: 8px;
  color: #ffffff;
  font-weight: 600;
  text-transform: uppercase;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.btn-pagination::before {
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

.btn-pagination:hover::before {
  width: 200px;
  height: 200px;
}

.btn-pagination:hover {
  background: #024077;
  color: #ffe900;
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5);
}

/* Responsividad */
@media (max-width: 768px) {
  .landing-main {
    padding: 1rem;
    margin-top: 140px; /* Ajuste para móviles */
  }

  .landing-header {
    padding: 2rem 1rem;
  }

  .landing-header h1 {
    font-size: 2.5rem;
  }

  .landing-header .subtitle {
    font-size: 1.2rem;
  }

  .buttons {
    flex-direction: column;
    gap: 1rem;
  }

  .btn {
    padding: 0.8rem 1.5rem;
    font-size: 1rem;
  }

  .conferences-grid {
    grid-template-columns: 1fr;
    padding: 1rem;
  }

  .conference-image {
    height: 180px;
  }

  .conference-details h3 {
    font-size: 1.5rem;
  }
}
</style>