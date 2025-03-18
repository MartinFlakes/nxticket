<template>
    <div class="contenedor-principal d-flex align-items-center justify-content-center vh-100">
      <div class="container">
        <div class="card bg-dark text-white">
          <div class="row g-0">
            <div class="col-md-5 d-flex">
              <img :src="evento.imagen" class="img-fluid rounded-start" alt="Imagen del evento">
            </div>
            <div class="col-md-7 d-flex align-items-center">
              <div class="card-body text-start">
                <h5 class="card-title text-uppercase kanit-bold">{{ evento.titulo }}</h5>
                <p class="card-text"><strong>Fecha:</strong> {{ evento.fecha }}</p>
                <p class="card-text"><strong>Hora:</strong> {{ evento.hora }}</p>
                <p class="card-text"><strong>Lugar:</strong> {{ evento.lugar }}</p>
                <p class="card-text"><strong>Ponentes:</strong> {{ evento.ponentes.join(', ') }}</p>
                <a href="#" class="btn btn-success w-100">Registrarse</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  <script>
  export default {
    data() {
      return {
        evento: {
          titulo: "OPERA METROPOLITANA EN VIVO",
          fecha: "Miércoles, 17 de septiembre de 2025",
          hora: "21:00 HRS",
          tipoEvento: "Concierto",
          lugar: "Auditorio Josefa Ortiz De Domínguez, Querétaro",
          ponentes: ["Artista Principal", "Invitado Especial"],
          imagen: "https://gamefaqs.gamespot.com/a/box/5/0/0/899500_front.jpg"
        }
      };
    }
  };
  </script>
  
  <style scoped>
  /* Fondo del contenedor */
  .contenedor-principal {
    background-color: #01569A;
    width: 100%;
    height: 100vh;
  }
  
  /* Centrar la tarjeta */
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }
  
  /* Estilos adicionales */
  .card {
    max-width: 1000px;
  }
  
  .btn {
    font-family: "Hiragino Sans", sans-serif;
  }
  </style>
  