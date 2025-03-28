<template>
  <div class="event-create-container">
    <div class="event-create-content">
      <h1>Comienza creando tus propios eventos</h1>
      <p>
        Únete a NxTicket y crea tus eventos en simples pasos. Administra,
        promociona y haz crecer tu audiencia con facilidad.
      </p>
      <button class="start-button" @click="goToEventRegister">Comenzar</button>
      <button class="start-button" @click="goToVenueRegister">Crear Lugar</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "EventCreateView",
  methods: {
    goToEventRegister() {
      this.$router.push("/event-pageregister");
    },
    goToVenueRegister() {
      this.$router.push("/venue-register");
    },
  },
};
</script>

<style scoped>
.event-create-container {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background: linear-gradient(135deg, #050517, #01569a);
  color: white;
  text-align: center;
  padding: 2rem;
  font-family: "Kanit", sans-serif;
}

.event-create-content {
  max-width: 600px;
}

h1 {
  font-size: 2.5rem;
  color: #ffe900;
  margin-bottom: 1rem;
}

p {
  font-size: 1.2rem;
  color: #ccc;
  margin-bottom: 2rem;
}

.start-button {
  padding: 0.75rem 1.5rem;
  font-size: 1.2rem;
  border-radius: 8px;
  margin: 0.5rem;
}
</style>