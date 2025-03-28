<template>
  <div class="venue-register-container">
    <h1>Registrar Nuevo Lugar</h1>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="name">Nombre del Lugar</label>
        <input type="text" id="name" v-model="venue.name" required />
      </div>
      <div class="form-group">
        <label for="address">Dirección</label>
        <input type="text" id="address" v-model="venue.address" required />
      </div>
      <div class="form-group">
        <label for="city">Ciudad</label>
        <input type="text" id="city" v-model="venue.city" required />
      </div>
      <div class="form-group">
        <label for="state">Estado</label>
        <input type="text" id="state" v-model="venue.state" required />
      </div>
      <div class="form-group">
        <label for="zip">Código Postal</label>
        <input type="text" id="zip" v-model="venue.zip" required />
      </div>
      <div class="form-group">
        <label for="capacity">Capacidad</label>
        <input type="number" id="capacity" v-model="venue.capacity" required />
      </div>
      <button type="button" class="submit-button" @click="createVenue">Registrar Lugar</button>
    </form>

    <h2 v-if="venueCreated">Registrar Zona</h2>
    <form @submit.prevent="submitZone" v-if="venueCreated">
      <div class="form-group">
        <label for="zone-name">Nombre de la Zona</label>
        <input type="text" id="zone-name" v-model="zone.name" required />
      </div>
      <div class="form-group">
        <label for="zone-capacity">Capacidad de la Zona</label>
        <input type="number" id="zone-capacity" v-model="zone.capacity" required />
      </div>
      <div class="form-group">
        <label for="zone-price">Precio de la Zona</label>
        <input type="number" step="0.01" id="zone-price" v-model="zone.price" required />
      </div>
      <button type="submit" class="submit-button">Registrar Zona</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "VenueRegister",
  data() {
    return {
      venue: {
        name: '',
        address: '',
        city: '',
        state: '',
        zip: '',
        capacity: ''
      },
      zone: {
        name: '',
        capacity: '',
        price: ''
      },
      venueCreated: false,
      venueId: null
    };
  },
  methods: {
    async createVenue() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/venues', this.venue);
        this.venueId = response.data.id;
        this.venueCreated = true;
        console.log('Lugar registrado:', response.data);
      } catch (error) {
        console.error('Error registrando el lugar:', error);
      }
    },
    async submitZone() {
      try {
        const zoneData = {
          ...this.zone,
          venue_id: this.venueId
        };
        const response = await axios.post('http://127.0.0.1:8000/api/zones', zoneData);
        console.log('Zona registrada:', response.data);
        // Redirigir o mostrar mensaje de éxito
      } catch (error) {
        console.error('Error registrando la zona:', error);
      }
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Contenedor Principal */
.venue-register-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
  position: relative;
  overflow: hidden;
  margin-top: 160px; /* Espacio para header y navbar fijos */
  font-family: 'Kanit', sans-serif;
  color: #ffffff;
}

/* Fondo decorativo */
.venue-register-container::before {
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

/* Títulos */
h1, h2 {
  text-align: center;
  margin-bottom: 2rem;
  font-size: 2.5rem;
  color: #ffe900; /* Amarillo como acento */
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(1, 86, 154, 0.7), 0 0 20px rgba(255, 233, 0, 0.5);
  position: relative;
  z-index: 1;
}

h2 {
  font-size: 2rem;
  margin-top: 2rem;
}

/* Grupo de Formulario */
.form-group {
  margin-bottom: 1.5rem;
  position: relative;
  z-index: 1;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-size: 1.2rem;
  color: #ffe900; /* Amarillo para etiquetas */
  font-weight: 500;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
}

input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #ffe900; /* Borde amarillo */
  border-radius: 8px;
  background: rgba(5, 5, 23, 0.5); /* #050517 como fondo secundario */
  color: #ffffff;
  font-family: 'Hiragino Sans', sans-serif;
  font-size: 1rem;
  transition: all 0.3s ease;
}

input:focus {
  outline: none;
  border-color: #ffffff;
  background: rgba(5, 5, 23, 0.7);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5); /* Sombra amarilla al foco */
}

/* Botón de Envío */
.submit-button {
  display: block;
  width: 100%;
  padding: 1rem;
  background: #01569a; /* #01569a como principal */
  color: #ffffff;
  border: 2px solid #ffe900; /* Borde amarillo */
  border-radius: 8px;
  cursor: pointer;
  font-family: 'Kanit', sans-serif;
  font-size: 1.2rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  margin-top: 1rem;
  z-index: 1;
}

.submit-button::before {
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

.submit-button:hover::before {
  width: 300px;
  height: 300px;
}

.submit-button:hover {
  background: #024077; /* Tono más oscuro de #01569a */
  color: #ffe900;
  transform: translateY(-2px);
  box-shadow: 0 0 15px rgba(255, 233, 0, 0.5); /* Sombra amarilla */
}

/* Responsividad */
@media (max-width: 768px) {
  .venue-register-container {
    padding: 1.5rem;
    margin-top: 140px; /* Ajuste para móviles */
  }

  h1 {
    font-size: 2rem;
  }

  h2 {
    font-size: 1.5rem;
  }

  .form-group {
    margin-bottom: 1rem;
  }

  label {
    font-size: 1rem;
  }

  input {
    padding: 0.6rem;
    font-size: 0.9rem;
  }

  .submit-button {
    padding: 0.8rem;
    font-size: 1rem;
  }
}
</style>