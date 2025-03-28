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
      </section>

      <!-- Espacio y Capacidad -->
      <section class="form-section">
        <h2>Espacio y Capacidad</h2>
        <div class="form-row">
          <div class="form-group">
            <label for="category">Categoría</label>
            <select v-model="event.category_id" id="category" required>
              <option value="" disabled>Selecciona una categoría</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="venue">Lugar</label>
            <select v-model="event.venue_id" id="venue" required>
              <option value="" disabled>Selecciona un lugar</option>
              <option v-for="venue in venues" :key="venue.id" :value="venue.id">{{ venue.name }} - {{ venue.address }}</option>
            </select>
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

      <button type="submit" class="btn-register">Registrar Evento</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      event: {
        title: '',
        description: '',
        category_id: '',
        venue_id: '',
        start_date: '',
        end_date: '',
        imagePreview: null,
        user_id: 1, // Usuario fijo
      },
      categories: [],
      venues: [],
      imageFile: null,
    };
  },
  methods: {
    async registerEvent() {
      try {
        const formData = new FormData();
        formData.append('title', this.event.title);
        formData.append('description', this.event.description);
        formData.append('start_date', this.event.start_date);
        formData.append('end_date', this.event.end_date);
        formData.append('category_id', this.event.category_id);
        formData.append('venue_id', this.event.venue_id);
        formData.append('user_id', this.event.user_id);

        // Añadir imagen si existe
        if (this.imageFile) {
          formData.append('image', this.imageFile);
        }

        // Añadir hosts
        const hosts = [{ id: 4, name: 'Casandra Parisian II', photo: 'https://via.placeholder.com/640x480.png/00aacc?text=ea' }];
        formData.append('hosts', JSON.stringify(hosts));

        const response = await axios.post('http://127.0.0.1:8000/api/events/create', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });

        alert(`Evento "${response.data.title}" registrado con éxito!`);
        this.$router.push('/myevents');
      } catch (error) {
        console.error('Error al registrar el evento:', error);
        alert('Hubo un error al registrar el evento. Intenta nuevamente.');
      }
    },
    onFileChange(event) {
      const file = event.target.files[0];
      this.imageFile = file;
      this.event.imagePreview = URL.createObjectURL(file);
    },
    async fetchData() {
      try {
        const [categoriesRes, venuesRes] = await Promise.all([
          axios.get('http://127.0.0.1:8000/api/categories'),
          axios.get('http://127.0.0.1:8000/api/venues')
        ]);

        this.categories = categoriesRes.data;
        this.venues = venuesRes.data;
      } catch (error) {
        console.error('Error al obtener datos:', error);
      }
    }
  },
  mounted() {
    this.fetchData();
  }
};
</script>

<style scoped>
/* Importación de fuentes */
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

/* Estilos Globales */
.event-register {
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  color: #ffffff;
  padding: 3rem;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
}

/* Fondo decorativo */
.event-register::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(1, 86, 154, 0.2), transparent 70%); /* #01569a tenue */
  animation: pulse 15s infinite ease-in-out;
  z-index: 0;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.5; }
  50% { transform: scale(1.1); opacity: 0.8; }
}

/* Header */
.register-header {
  text-align: center;
  margin-bottom: 3rem;
  position: relative;
  z-index: 1;
}

.register-header h1 {
  font-size: 3rem;
  color: #ffe900; /* Principal como base */
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(1, 86, 154, 0.7), 0 0 20px rgba(255, 233, 0, 0.5); /* Sombra con #01569a y toque de #ffe900 */
  margin-bottom: 0.5rem;
  animation: glow 2s infinite alternate;
}

@keyframes glow {
  0% { text-shadow: 0 0 10px rgba(1, 86, 154, 0.7), 0 0 20px rgba(255, 233, 0, 0.5); }
  100% { text-shadow: 0 0 15px rgba(1, 86, 154, 0.9), 0 0 30px rgba(255, 233, 0, 0.7); }
}

.register-header p {
  font-size: 1.3rem;
  color: #ccc; /* Gris claro del landing */
  font-family: 'Hiragino Sans', sans-serif;
  opacity: 0.85;
  font-style: italic;
}

/* Formulario */
.register-form {
  max-width: 900px;
  width: 100%;
  background: rgba(1, 86, 154, 0.9); /* #01569a como fondo principal */
  padding: 2.5rem;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4), inset 0 0 10px rgba(255, 233, 0, 0.2); /* Toque de #ffe900 */
  position: relative;
  z-index: 1;
  border: 2px solid #ffe900; /* Borde amarillo como acento */
}

/* Secciones */
.form-section {
  margin-bottom: 3rem;
  position: relative;
}

.form-section h2 {
  font-size: 1.8rem;
  color: #ffe900; /* Amarillo como acento */
  margin-bottom: 1.5rem;
  position: relative;
  display: inline-block;
}

.form-section h2::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 50%;
  height: 3px;
  background: #01569a; /* Línea en #01569a */
  border-radius: 2px;
  box-shadow: 0 0 8px #01569a;
}

/* Filas y Grupos */
.form-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  width: 100%;
  position: relative;
}

label {
  font-size: 1.1rem;
  font-weight: 500;
  margin-bottom: 0.6rem;
  color: #ddd; /* Gris claro */
  text-transform: uppercase;
  letter-spacing: 1px;
  font-family: 'Kanit', sans-serif;
}

input,
textarea,
select {
  padding: 1rem;
  border: 2px solid rgba(1, 86, 154, 0.5); /* Borde con #01569a */
  border-radius: 10px;
  font-size: 1rem;
  background-color: rgba(5, 5, 23, 0.2); /* #050517 como fondo secundario */
  color: #ffffff;
  transition: all 0.3s ease;
  box-shadow: inset 0 0 5px rgba(1, 86, 154, 0.3);
  font-family: 'Hiragino Sans', sans-serif;
}

input:focus,
textarea:focus,
select:focus {
  border-color: #ffe900; /* Amarillo como acento al enfocar */
  background-color: rgba(5, 5, 23, 0.4);
  box-shadow: 0 0 12px rgba(1, 86, 154, 0.7); /* Sombra con #01569a */
  transform: scale(1.02);
}

textarea {
  resize: vertical;
  min-height: 140px;
}

select {
  appearance: none;
  background-image: url('data:image/svg+xml;utf8,<svg fill="%2301569a" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>'); /* Flecha en #01569a */
  background-repeat: no-repeat;
  background-position: right 1rem top 50%;
  padding-right: 2.5rem;
}

/* Imagen */
.image-preview {
  max-width: 250px;
  margin-top: 1.5rem;
  border-radius: 12px;
  border: 3px solid #01569a; /* Borde principal */
  box-shadow: 0 0 15px rgba(1, 86, 154, 0.5);
  transition: transform 0.3s ease;
}

.image-preview:hover {
  transform: scale(1.05);
  border-color: #ffe900; /* Cambio a amarillo al hover */
}

/* Botón */
.btn-register {
  background: #01569a; /* #01569a como principal */
  color: #ffffff; /* Blanco para contraste */
  padding: 1.2rem;
  font-size: 1.3rem;
  font-weight: 600;
  border: 2px solid #ffe900; /* Borde amarillo como acento */
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-family: 'Kanit', sans-serif;
}

.btn-register::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255, 233, 0, 0.3); /* Efecto ripple con #ffe900 */
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s ease, height 0.6s ease;
}

.btn-register:hover::before {
  width: 300px;
  height: 300px;
}

.btn-register:hover {
  background: #024077; /* Tono más oscuro de #01569a */
  box-shadow: 0 0 20px rgba(1, 86, 154, 0.8);
  transform: translateY(-3px);
  color: #ffe900; /* Texto amarillo al hover */
}

/* Responsividad */
@media (max-width: 600px) {
  .event-register {
    padding: 1.5rem;
  }

  .register-header h1 {
    font-size: 2.2rem;
  }

  .form-section h2 {
    font-size: 1.5rem;
  }

  .register-form {
    padding: 2rem;
  }       

  .btn-register {
    font-size: 1.1rem;
    padding: 1rem;
  }
}
</style>