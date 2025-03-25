<template>
  <div class="event-register">
    <header class="register-header">
      <h1>Registra tu Evento</h1>
      <p>Crea y gestiona eventos de forma rápida y sencilla.</p>
    </header>

    <form @submit.prevent="registerEvent" class="register-form">
      <!-- Datos Generales -->
      <section class="form-section">
        <h2>Datos Generales</h2>
        <div class="form-group">
          <label for="title">Título del Evento</label>
          <input v-model="event.title" type="text" id="title" required placeholder="Introduce el título del evento" />
        </div>
        <div class="form-group">
          <label for="description">Descripción</label>
          <textarea v-model="event.description" id="description" required placeholder="Describe tu evento"></textarea>
        </div>
      </section>

      <!-- Fecha y Lugar -->
      <section class="form-section">
        <h2>Fecha y Ubicación</h2>
        <div class="form-row">
          <div class="form-group">
            <label for="start_date">Fecha de Inicio</label>
            <input v-model="event.start_date" type="datetime-local" id="start_date" required />
          </div>
          <div class="form-group">
            <label for="end_date">Fecha de Finalización</label>
            <input v-model="event.end_date" type="datetime-local" id="end_date" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="city">Ciudad</label>
            <input v-model="event.city" type="text" id="city" required placeholder="Introduce la ciudad" />
          </div>
          <div class="form-group">
            <label for="state">Estado</label>
            <input v-model="event.state" type="text" id="state" required placeholder="Introduce el estado" />
          </div>
        </div>
        <div class="form-group">
          <label for="address">Dirección</label>
          <input v-model="event.address" type="text" id="address" required placeholder="Introduce la dirección" />
        </div>
      </section>

      <!-- Espacio y Capacidad -->
      <section class="form-section">
        <h2>Espacio y Capacidad</h2>
        <div class="form-row">
          <div class="form-group">
            <label for="category">Categoría</label>
            <select v-model="event.category_id" id="category" required>
              <option value="" disabled>Selecciona una categoría</option>
              <option class="form-category" v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="venue">Lugar</label>
            <select v-model="event.venue_id" id="venue" required>
              <option value="" disabled>Selecciona un lugar</option>
              <option class="form-category" v-for="venue in venues" :key="venue.id" :value="venue.id">{{ venue.name }} - {{ venue.address }}</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="capacity">Capacidad</label>
            <input v-model="event.capacity" type="number" id="capacity" required placeholder="Capacidad del lugar" />
          </div>
          <div class="form-group">
            <label for="seats">Número de Asientos</label>
            <input v-model="event.seats" type="number" id="seats" required placeholder="Número de asientos" />
          </div>
        </div>
        <div class="form-group">
          <label for="row">Fila</label>
          <input v-model="event.row" type="number" id="row" required placeholder="Fila de los asientos" />
        </div>
      </section>

      <!-- Vista Previa del Lugar -->
      <section class="form-section">
        <h2>Vista Previa del Lugar</h2>
        <div class="stadium-preview">
          <div v-if="stadiumRows.length > 0 && stadiumRows[0].length > 0" class="stadium-stage">
            <span>Tarima</span>
          </div>
          <div v-for="(row, rowIndex) in stadiumRows" :key="rowIndex" class="stadium-row">
            <div v-for="(seat, seatIndex) in row" :key="seatIndex" class="stadium-seat"></div>
          </div>
        </div>
      </section>

      <!-- Imagen del Evento -->
      <section class="form-section">
        <h2>Imagen del Evento</h2>
        <div class="form-group">
          <label for="eventImage">Subir Imagen</label>
          <input type="file" id="eventImage" @change="onFileChange" accept="image/*" />
          <img v-if="event.imagePreview" :src="event.imagePreview" alt="Vista previa" class="image-preview" />
        </div>
      </section>

      <!-- Precio -->
      <section class="form-section">
        <h2>Detalles del Precio</h2>
        <div class="form-group">
          <label for="price">Precio</label>
          <input v-model="event.price" type="number" step="0.01" id="price" required placeholder="Introduce el precio" />
        </div>
      </section>

      <button type="submit" class="btn-register">Registrar Evento</button>
    </form>
  </div>
</template>


<script>
export default {
  data() {
    return {
      event: {
        title: '',
        description: '',
        category_id: '',
        venue_id: '',
        city: '',
        state: '',
        address: '',
        capacity: '',
        price: '',
        seats: 0,
        row: 0,
        start_date: '',
        end_date: ''
      },
      categories: [],
      venues: [],
    };
  },
  computed: {
    stadiumRows() {
      const rows = [];
      const seatCount = this.event.seats;
      const rowCount = this.event.row;

      for (let i = 0; i < rowCount; i++) {
        const row = new Array(seatCount).fill(null);
        rows.push(row);
      }
      return rows;
    },
  },
 methods: {
  registerEvent() {
    alert(`Evento "${this.event.title}" registrado con éxito!`);
    
    // Redirigir a /myevents
    this.$router.push('/myevents');
  }
},

  mounted() {
    this.categories = [
      { id: 1, name: 'Conciertos' },
      { id: 2, name: 'Conferencias' }
    ];
    this.venues = [
      { id: 1, name: 'Auditorio Central', address: 'Ciudad de México' },
      { id: 2, name: 'Estadio Nacional', address: 'Guadalajara' }
    ];
  }
};
</script>

<style scoped>
.form-category {
  color:rgba(53, 53, 53, 0.5);
  font-family: "Kanit", sans-serif;

}
/* Global Styles */
.event-register {
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  padding: 3rem;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-family: "Kanit", sans-serif;

}

.register-header h1 {
  font-size: 2.5rem;
  color: #ffe900;
  margin-bottom: 1rem;
}

.register-header p {
  font-size: 1.2rem;
  margin-bottom: 2rem;
}

.form-section {
  margin-bottom: 2rem;
}

.form-section h2 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
  color: #ffe900;
}

.stadium-preview {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  position: relative;
  margin-top: 2rem;
}

.stadium-stage {
  width: 80%;
  height: 40px;
  background-color: #ff5722;
  border-radius: 8px;
  margin-bottom: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  color: white;
  text-transform: uppercase;
}

.stadium-row {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
}

.stadium-seat {
  width: 20px;
  height: 20px;
  background-color: rgb(255, 255, 255);
  border-radius: 50%;
  animation: seatAnimation 0.5s ease;
}

@keyframes seatAnimation {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}

.register-form {
  max-width: 800px;
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-row {
  display: flex;
  justify-content: space-between;
  gap: 1.5rem;
}
.form-group {
  display: flex;
  flex-direction: column;
  text-align: left;
  width: 48%;
}
label {
  font-size: 1rem;
  font-weight: bold;
  margin-bottom: 0.3rem;
}
input, textarea, select {
  padding: 0.9rem;
  border: 1px solid #fff;
  border-radius: 8px;
  font-size: 1rem;
  margin-top: 0.3rem;
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
}
input:focus, textarea:focus, select:focus {
  border-color: #ffe900;
  outline: none;
}
textarea {
  resize: vertical;
  min-height: 100px;
}
.btn-register {
  background: #ffe900;
  color: #050517;
  padding: 1rem;
  font-size: 1.2rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
  width: 100%;
}
.btn-register:hover {
  background: #e6d100;
}
select {
  font-size: 1rem;
}

</style>
