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
  
      <h2>Registrar Zona</h2>
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
  .venue-register-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  h1, h2 {
    text-align: center;
    margin-bottom: 1.5rem;
  }
  
  .form-group {
    margin-bottom: 1rem;
  }
  
  label {
    display: block;
    margin-bottom: 0.5rem;
  }
  
  input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .submit-button {
    display: block;
    width: 100%;
    padding: 0.75rem;
    background-color: #01569a;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 1rem;
  }
  
  .submit-button:hover {
    background-color: #014a85;
  }
  </style>