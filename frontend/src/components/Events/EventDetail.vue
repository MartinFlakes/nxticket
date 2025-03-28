<template>
  <div class="contenedor-principal d-flex align-items-center justify-content-center vh-100">
    <div class="container">
      <div class="custom-card text-white">
        <div class="row g-0">
          <div class="col-md-5 d-flex justify-content-center align-items-center">
            <img :src="evento.image_url" class="img-fluid rounded-start" alt="Imagen del evento">
          </div>
          <div class="col-md-7 d-flex flex-column justify-content-between p-4">
            <div>
              <h5 class="card-title">{{ evento.title }}</h5>
              <div class="evento-details">
                <!-- Información del Evento -->
                <div class="detail-item">
                  <strong>Fecha:</strong> <span>{{ formatDate(evento.start_date) }} - {{ formatDate(evento.end_date) }}</span>
                </div>
                <div class="detail-item">
                  <strong>Lugar:</strong> <span>{{ venue.name }}</span>
                </div>
                <div class="detail-item">
                  <strong>Dirección:</strong> <span>{{ venue.address }}</span>
                </div>
                <div class="detail-item">
                  <strong>Ciudad:</strong> <span>{{ venue.city }}</span>
                </div>
                <div class="detail-item">
                  <strong>Estado:</strong> <span>{{ venue.state }}</span>
                </div>
           
              </div>
            </div>
            <button class="conf-btn w-100" @click="registrarse">Registrarse</button>
          </div>
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
      evento: {
        title: "",
        description: "",
        image_url: "",
        start_date: "",
        end_date: "",
        venue_id: "",
        hosts: [],
      },
      venue: {
        name: "",
        address: "",
        city: "",
        state: "",
      }
    };
  },
  methods: {
    // Función para obtener los detalles del evento
    async fetchEventDetails() {
      const eventTitle = this.$route.params.title;
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/events/title/${eventTitle}`);
        this.evento = response.data.data[0]; 
        await this.fetchVenueDetails(); // Obtener detalles del venue
      } catch (error) {
        console.error("Error fetching event details:", error);
      }
    },
    async fetchVenueDetails() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/venues`);
        const venue = response.data.find(venue => venue.id === this.evento.venue_id);
        if (venue) {
          this.venue = venue;
        } else {
          console.error("Venue no encontrado");
        }
      } catch (error) {
        console.error("Error fetching venues:", error);
      }
    },
    registrarse() {
      console.log("Usuario registrado en el evento:", this.evento.title);
      alert(`Te has registrado en: ${this.evento.title}`);
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString("es-ES", { year: 'numeric', month: 'long', day: 'numeric' });
    }
  },
  created() {
    this.fetchEventDetails();
  }
};
</script>

<style scoped>
/* Fondo del contenedor */
.contenedor-principal {
  text-align: center;
  padding: 2rem;
  min-height: 100vh;
  background: linear-gradient(135deg, #01569a, #050517);
  color: #ffffff;
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
  margin-top: 100px; /* Espacio para header y navbar fijos */
}

/* Centrar la tarjeta */
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

/* Estilos del card */
.custom-card {
  max-width: 900px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  background-color: #01569A;
  padding: 30px;
  transition: transform 0.3s ease;
}

.custom-card:hover {
  transform: translateY(-5px);
}

/* Estilo de título */
.card-title {
  font-family: 'Roboto', sans-serif;
  font-weight: 700;
  font-size: 2rem;
  color: #FFFFFF;
  text-transform: uppercase;
  margin-bottom: 20px;
}

/* Detalles del evento */
.evento-details {
  font-family: 'Roboto', sans-serif;
  color: #E1E8EB;
  font-size: 1rem;
}

.detail-item {
  margin-bottom: 12px;
}

.detail-item strong {
  color: #ffe900;
}

.conf-btn {
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

.conf-btn::before {
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

.conf-btn:hover::before {
  width: 200px;
  height: 200px;
}

.conf-btn:hover {
  background: #024077;
  color: #ffe900;
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5);
}

img {
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  max-width: 100%;
  object-fit: cover;
}

/* Ajustes en pantallas pequeñas */
@media (max-width: 767px) {
  .custom-card {
    padding: 20px;
  }
  .card-title {
    font-size: 1.5rem;
  }
}
</style>
