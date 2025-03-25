<template>
  <div class="user-view">
    <header class="user-header">
      <h1>Bienvenido, {{ user.firstName }} {{ user.lastName }}</h1>
      <p>Aquí puedes ver tus inscripciones y explorar nuevas conferencias.</p>
    </header>

    <section class="user-content">
      <div class="user-subscriptions">
        <h2>Tus Inscripciones</h2>
        <ul v-if="subscriptions.length > 0">
          <li v-for="event in subscriptions" :key="event.id">
            <router-link :to="{ name: 'event-page', params: { id: event.id } }" class="event-link">
              {{ event.nombre }} - {{ event.fecha }}
            </router-link>
          </li>
        </ul>
        <p v-else>No tienes inscripciones activas.</p>
      </div>

      <div class="available-conferences">
        <h2>Conferencias Disponibles</h2>
        <ul>
          <li v-for="event in availableEvents" :key="event.id">
            <router-link :to="{ name: 'event-page', params: { id: event.id } }" class="event-link">
              {{ event.nombre }} - {{ event.fecha }}
            </router-link>
            <button @click="subscribe(event)">Inscribirse</button>
          </li>
        </ul>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        firstName: "John",
        lastName: "Doe",
        email: "john.doe@example.com",
      },
      subscriptions: [],
      availableEvents: [
        { id: 1, nombre: "Conferencia de Tecnología", fecha: "2025-06-15" },
        { id: 2, nombre: "Meetup de Innovación", fecha: "2025-06-20" },
        { id: 3, nombre: "Foro de Emprendimiento", fecha: "2025-07-05" },
      ],
    };
  },
  methods: {
    subscribe(event) {
      this.subscriptions.push(event);
      alert(`Te has inscrito a: ${event.nombre}`);
    },
  },
};
</script>

<style scoped>
.user-view {
  padding: 2rem;
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  font-family: 'Kanit', sans-serif;
  min-height: 100vh;
}

.user-header {
  text-align: center;
  margin-bottom: 2rem;
}

.user-header h1 {
  font-size: 2.5rem;
  color: #ffe900;
}

.user-header p {
  font-size: 1.25rem;
  color: #ccc;
}

.user-content {
  display: flex;
  gap: 2rem;
  padding: 1rem;
}

.user-subscriptions,
.available-conferences {
  flex: 1;
  background: rgba(255, 255, 255, 0.1);
  padding: 1.5rem;
  border-radius: 10px;
}

h2 {
  font-size: 1.75rem;
  color: #ffe900;
  margin-bottom: 1rem;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  background: rgba(255, 255, 255, 0.1);
  padding: 0.75rem;
  margin-bottom: 0.5rem;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.event-link {
  color: white;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease;
}

.event-link:hover {
  color: #ffe900;
}

button {
  background: #ffe900;
  color: #050517;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #e6d100;
}

@media (max-width: 768px) {
  .user-content {
    flex-direction: column;
  }
}
</style>
