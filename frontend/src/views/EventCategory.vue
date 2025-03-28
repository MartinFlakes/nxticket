<template>
  <main class="landing-main">
    <section class="conferences-grid">
      <div v-if="eventsData.data.length === 0" class="no-events">
        <p>No hay eventos disponibles.</p>
      </div>
      <div v-else v-for="event in eventsData.data" :key="event.id" 
           :class="['conference-item', event.size]">
        <img :src="event.imag" :alt="event.title" class="conference-image" />
        <div class="conference-details">
          <h3>{{ event.title }}</h3>
          <div class="conf-date">
            {{ formatDate(event.start_date) }} - {{ formatDate(event.end_date) }}
          </div>
          <p><strong>Categoría:</strong> {{ event.categories.name }}</p>
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
    <div class="pagination" v-if="eventsData.data.length > 0">
      <button
        v-if="eventsData.prev_page_url"
        @click="fetchEvents(eventsData.prev_page_url)"
        class="btn-pagination"
      >
        Anterior
      </button>
      <span>{{ eventsData.current_page }} de {{ eventsData.last_page }}</span>
      <button
        v-if="eventsData.next_page_url"
        @click="fetchEvents(eventsData.next_page_url)"
        class="btn-pagination"
      >
        Siguiente
      </button>
    </div>
  </main>
</template>

<script setup>
import { ref, watch } from "vue";
import axios from "axios";

const props = defineProps({
  category: String // Prop para recibir la categoría seleccionada
});

const eventsData = ref({
  data: [],
  next_page_url: null,
  prev_page_url: null,
  current_page: 1,
  last_page: 1
});

const fetchEvents = async (url = null) => {
  const apiUrl = url || `http://127.0.0.1:8000/api/events/categories/${props.category}&page=1`;
  try {
    const response = await axios.get(apiUrl);
    eventsData.value = response.data;
  } catch (error) {
    console.error("Error fetching events:", error);
  }
};

// Observar cambios en la categoría y volver a cargar los eventos
watch(() => props.category, () => {
  fetchEvents();
}, { immediate: true });

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString("es-ES", { year: 'numeric', month: 'long', day: 'numeric' });
};

// Llamada inicial para cargar los eventos
fetchEvents();
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap");

/* Contenedor Principal */
.landing-main {
  text-align: center;
  padding: 2rem;
  min-height: 100vh;
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  color: #ffffff;
  font-family: "Kanit", sans-serif;
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

/* Conferences Grid */
.conferences-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 2rem;
  padding: 2rem;
  position: relative;
  z-index: 1;
}

/* Mensaje de No Eventos */
.no-events {
  text-align: center;
  font-size: 2rem;
  color: #ffe900; /* Amarillo como acento */
  margin: 4rem 0;
  font-family: "Kanit", sans-serif;
  text-shadow: 0 0 10px rgba(1, 86, 154, 0.7);
  animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* Conference Item */
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
  font-family: "Kanit", sans-serif;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
}

.conf-date {
  font-size: 1rem;
  color: #ccc;
  margin-bottom: 1rem;
  font-family: "Hiragino Sans", sans-serif;
}

.conference-details p {
  font-size: 1.1rem;
  color: #ddd;
  margin-bottom: 1rem;
  font-family: "Hiragino Sans", sans-serif;
}

.conference-details p strong {
  color: #ffe900; /* Resaltar etiquetas */
}

/* Botón de Inscripción */
.conf-btn {
  display: inline-block;
  background: #01569a; /* #01569a como principal */
  padding: 0.75rem 1.5rem;
  text-decoration: none;
  font-weight: 600;
  color: #ffffff;
  border: 2px solid #ffe900; /* Borde amarillo */
  border-radius: 8px;
  transition: all 0.3s ease;
  font-family: "Kanit", sans-serif;
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 1px;
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
  font-family: "Hiragino Sans", sans-serif;
}

.btn-pagination {
  background: #01569a; /* #01569a como principal */
  padding: 0.75rem 1.5rem;
  border: 2px solid #ffe900; /* Borde amarillo */
  border-radius: 8px;
  color: #ffffff;
  font-weight: 600;
  text-transform: uppercase;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  font-family: "Kanit", sans-serif;
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
  background: #024077; /* Tono más oscuro de #01569a */
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

  .no-events {
    font-size: 1.5rem;
    margin: 2rem 0;
  }

  .pagination {
    gap: 1rem;
    flex-wrap: wrap;
  }

  .btn-pagination {
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
  }
}
</style>