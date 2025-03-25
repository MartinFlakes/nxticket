<template>
  <div class="container-fluid" style="background-color: #050517;">
    <nav class="container navbar navbar-expand-lg ">
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
      <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Conciertos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Comedia</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Conferencias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Meetups</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Festivales</a>
          </li>
          <li class="nav-item">
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
};
</script>

<style scoped>
.navbar {
  margin-bottom: 20px;
}
</style>
