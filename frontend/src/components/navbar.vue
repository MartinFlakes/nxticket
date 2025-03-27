<template>
  <div class="container-fluid" style="background-color: #050517;">
    <nav class="container navbar navbar-expand-lg">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '1' } }">Comedia</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '2' } }">Conferencias</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '4' } }">Meetups</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" :to="{ name: 'EventCategory', params: { category: '7' } }">Festivales</router-link>
          </li>
          <!-- Solo mostrar esta opción si el usuario es administrador -->
          <li class="nav-item" v-if="isAdmin">
            <router-link class="nav-link text-white" to="/event-register">Crear Eventos</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      isAdmin: false, // Variable para determinar si el usuario es admin
      isUser: false,  // Variable para determinar si el usuario es user
    };
  },
  mounted() {
    this.checkUserStatus();
  },
  methods: {
    checkUserStatus() {
      // Verifica si hay un token en el localStorage
      const token = localStorage.getItem("token");
      console.log("Token:", token); // Verifica que el token se está recuperando correctamente
      if (token) {
        // Si hay un token, intentar obtener los datos del usuario
        const userData = JSON.parse(localStorage.getItem("userData")); // Suponiendo que guardas los datos del usuario junto con el token
        console.log("User Data:", userData); // Verifica que los datos del usuario se están recuperando correctamente
        if (userData) {
          if (userData.role === "admin") {
            this.isAdmin = true; // Si el rol es admin, mostramos la opción de crear eventos
          } else if (userData.role === "user") {
            this.isUser = true; // Si el rol es user, ocultamos la opción de crear eventos
          }
        }
      }
    }
  }
};
</script>

<style scoped>
.navbar {
  margin-bottom: 20px;
}
</style>