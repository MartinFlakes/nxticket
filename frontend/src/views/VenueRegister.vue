<template>
  <div class="venue-register-container">
    <h1>Registrar Nuevo Lugar</h1>
    <form @submit.prevent="createVenue">
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
      <button type="submit" class="submit-button">Registrar Lugar</button>
    </form>

    <h2 v-if="venueCreated">Registrar Zonas</h2>
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
      <div class="button-group">
        <button type="button" class="submit-button" @click="submitZone">Agregar Otra Zona</button>
        <button type="button" class="submit-button" @click="finalizeRegistration">Finalizar Registro</button>
      </div>
    </form>

    <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "VenueRegister",
  data() {
    return {
      venue: {
        name: "",
        address: "",
        city: "",
        state: "",
        zip: "",
      },
      zone: {
        name: "",
        capacity: "",
        price: "",
      },
      venueCreated: false,
      venueId: null,
      successMessage: null,
      errorMessage: null,
    };
  },
  methods: {
    async createVenue() {
      console.log("Intentando registrar el lugar...");
      try {
        this.successMessage = null;
        this.errorMessage = null;

        const token = localStorage.getItem("access_token");
        console.log("Token obtenido:", token);

        if (!token) {
          this.errorMessage = "No se encontró el token de autenticación. Por favor, inicia sesión.";
          console.error(this.errorMessage);
          return;
        }

        const response = await axios.post(
          "http://127.0.0.1:8000/api/venue",
          this.venue,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        console.log("Respuesta del servidor:", response.data);

        this.venueId = response.data.venue.id;
        this.venueCreated = true;
        this.successMessage = "Lugar registrado exitosamente.";
        console.log("Lugar registrado exitosamente con ID:", this.venueId);
      } catch (error) {
        console.error("Error registrando el lugar:", error.response?.data || error.message);
        this.errorMessage =
          error.response?.data?.message || "Hubo un error al registrar el lugar. Por favor, intenta nuevamente.";
      }
    },
    async submitZone() {
      console.log("Intentando registrar la zona...");
      try {
        this.successMessage = null;
        this.errorMessage = null;

        const token = localStorage.getItem("access_token");
        console.log("Token obtenido:", token);

        if (!token) {
          this.errorMessage = "No se encontró el token de autenticación. Por favor, inicia sesión.";
          console.error(this.errorMessage);
          return;
        }

        const zoneData = {
          ...this.zone,
          venue_id: this.venueId,
        };

        console.log("Datos de la zona a enviar:", zoneData);

        const response = await axios.post(
          "http://127.0.0.1:8000/api/zone",
          zoneData,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        console.log("Respuesta del servidor:", response.data);

        this.successMessage = "Zona registrada exitosamente.";
        console.log("Zona registrada exitosamente.");

        // Limpiar los campos de la zona después de registrar
        this.zone.name = "";
        this.zone.capacity = "";
        this.zone.price = "";
      } catch (error) {
        console.error("Error registrando la zona:", error.response?.data || error.message);
        this.errorMessage =
          error.response?.data?.message || "Hubo un error al registrar la zona. Por favor, intenta nuevamente.";
      }
    },
    finalizeRegistration() {
      console.log("Finalizando registro...");
      this.successMessage = "Registro completado. Redirigiendo a la página de eventos...";
      this.errorMessage = null;

      // Redirigir a la página de registro de eventos
      this.$router.push("/event-register");
    },
  },
};
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Contenedor Principal */
.venue-register-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
  background: linear-gradient(135deg, #01569a, #050517);
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
  font-family: "Kanit", sans-serif;
  color: #ffffff;
}

/* Títulos */
h1,
h2 {
  text-align: center;
  margin-bottom: 2rem;
  font-size: 2.5rem;
  color: #ffe900;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(1, 86, 154, 0.7), 0 0 20px rgba(255, 233, 0, 0.5);
}

h2 {
  font-size: 2rem;
  margin-top: 2rem;
}

/* Grupo de Formulario */
.form-group {
  margin-bottom: 1.5rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-size: 1.2rem;
  color: #ffe900;
}

input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #ffe900;
  border-radius: 8px;
  background: rgba(5, 5, 23, 0.5);
  color: #ffffff;
  font-size: 1rem;
}

input:focus {
  outline: none;
  border-color: #ffffff;
  background: rgba(5, 5, 23, 0.7);
  box-shadow: 0 0 10px rgba(255, 233, 0, 0.5);
}

/* Botón de Envío */
.submit-button {
  display: block;
  width: 100%;
  padding: 1rem;
  background: #01569a;
  color: #ffffff;
  border: 2px solid #ffe900;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1.2rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease;
}

.submit-button:hover {
  background: #024077;
  color: #ffe900;
  transform: translateY(-2px);
  box-shadow: 0 0 15px rgba(255, 233, 0, 0.5);
}

/* Mensajes */
.success-message {
  color: #4caf50;
  text-align: center;
  margin-top: 1rem;
}

.error-message {
  color: #f44336;
  text-align: center;
  margin-top: 1rem;
}
</style>