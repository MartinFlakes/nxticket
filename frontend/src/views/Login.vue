<template>
  <div class="login-wrapper">
    <div class="login-container">
      <div class="login-left">
        <img src="@/assets/images/events.png" alt="Event Image" class="welcome-image" />
      </div>
      <div class="login-right">
        <h2>{{ isSignUp ? 'Sign Up' : 'Sign In' }}</h2>
        <p class="subtitle">
          {{ isSignUp ? 'Already have an account?' : 'New to NxTicket?' }} 
          <a href="#" @click.prevent="toggleForm">{{ isSignUp ? 'Sign In' : 'Sign Up' }}</a>
        </p>

        <form @submit.prevent="handleSubmit">
          <div v-if="isSignUp">
            <label for="name">Full Name</label>
            <input type="text" id="name" v-model="name" placeholder="Enter your full name" required />
          </div>

          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" placeholder="Enter your email" required />

          <label for="password">Password</label>
          <div class="password-container">
            <input :type="showPassword ? 'text' : 'password'" id="password" v-model="password" placeholder="Enter your password" required />
          </div>

          <div v-if="isSignUp">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" v-model="password_confirmation" placeholder="Confirm your password" required />
          </div>

          <div v-if="passwordError" class="error-message">{{ passwordError }}</div>

          <div class="options">
            <a href="#" class="forgot-password" v-if="!isSignUp">Forgot Password?</a>
          </div>

          <p class="terms">
            By continuing, you agree to the <a href="#">Terms of Use</a> and our <a href="#">Privacy Policy</a>.
          </p>

          <button type="submit" class="btn-signin">
            {{ isSignUp ? 'Register' : 'Sign In' }}
          </button>
        </form>

        <!-- Mostrar nombre del usuario si está logueado -->
        <div v-if="user">
          <p>Welcome, {{ user.name }}!</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { registerUser, loginUser } from '@/services/authService';

export default {
  data() {
    return {
      isSignUp: false,
      email: '',
      password: '',
      password_confirmation: '',
      name: '',
      showPassword: false,
      user: null,
      passwordError: '', // Error para contraseña
    };
  },
  methods: {
    async handleSubmit() {
      if (this.isSignUp) {
        await this.register();
      } else {
        await this.login();
      }
    },

    async register() {
  // Agregar depuración para ver los valores de las contraseñas
    console.log("Contraseña:", this.password);
    console.log("Confirmación de contraseña:", this.password_confirmation);

  // Validación de que las contraseñas coincidan
    if (this.password.trim() !== this.password_confirmation.trim()) {
    this.passwordError = "Las contraseñas no coinciden.";
    console.log("Las contraseñas NO coinciden.");
    return;
  }

      console.log("Las contraseñas coinciden.");

    this.passwordError = ''; // Limpiar error si las contraseñas coinciden

    const userData = {
      name: this.name,
      email: this.email,
      password: this.password,
      password_confirmation: this.password_confirmation, // Incluir la confirmación de contraseña
    };

      try {
        // Realizar el registro
        const response = await registerUser(userData);
        console.log("Respuesta del registro:", response);
      
        // Desestructurar el JWT y el usuario
        const { access_token, user } = response;
      
        // Guardar el token y usuario
        localStorage.setItem('access_token', access_token);
        localStorage.setItem('user', JSON.stringify(user));
      
        // Guardar usuario en el estado del componente
        this.user = user;
      
        console.log("JWT Token: ", access_token);
        console.log("Usuario registrado: ", user.name);
      
        // Llamar al loginUser para obtener el rol y continuar
        await this.loginUser(user);
      
        // Redirigir a la página principal o la ruta solicitada
        const redirectPath = this.$route.query.redirect || '/';
        this.$router.replace(redirectPath); // Reemplaza la ruta actual
      } catch (error) {
        console.error("Error en el registro: ", error);
        alert(error.response?.data?.message || error.message || "Hubo un error al registrar.");
      }
    },

    async login() {
      if (!this.email || !this.password) {
        alert("Por favor ingresa tu correo y contraseña.");
        return;
      }

      try {
        const response = await loginUser({
          email: this.email,
          password: this.password,
        });

        // Guardar el token y usuario
        const { access_token, user } = response;
        localStorage.setItem('access_token', access_token);
        localStorage.setItem('user', JSON.stringify(user));

        // Guardar usuario en el estado del componente
        this.user = user;

        console.log("JWT Token: ", access_token);
        console.log("Usuario logueado: ", user.name);

        // Obtener la ruta de redirección desde los parámetros de la URL
        const redirectPath = this.$route.query.redirect || '/'; // Redirige a / si no se encuentra ninguna ruta
        this.$router.replace(redirectPath); // Esto reemplaza la ruta sin dejar que el usuario regrese

      } catch (error) {
        alert(error.response?.data?.message || error.message || "Hubo un error en el inicio de sesión.");
      }
    },

    async loginUser(user) {
      try {
        const response = await loginUser({
          email: this.email,
          password: this.password,
        });

        const { access_token, user: loggedInUser } = response;
        localStorage.setItem('access_token', access_token);
        localStorage.setItem('user', JSON.stringify(loggedInUser));
        this.user = loggedInUser;

        console.log("Login exitoso:", loggedInUser.name);
      } catch (error) {
        console.error("Error al hacer login después de registro", error);
      }
    },

    toggleForm() {
      this.isSignUp = !this.isSignUp;
      this.passwordError = ''; // Limpiar error cuando se cambia de formulario
    },
  },
  mounted() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
    }
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&family=Hiragino+Sans:wght@300;400;500&display=swap');

.login-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  padding: 100px;
  background: linear-gradient(135deg, #050517, #01569a);
  font-family: 'Kanit', sans-serif;
}

.login-container {
  display: flex;
  width: 1000px;
  border-radius: 8px;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.1);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.login-left {
  width: 40%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.welcome-image {
  width: 100%;
  max-width: 100%;
}

.login-right {
  width: 60%;
  padding: 40px;
  color: white;
}

h2 {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: #ffe900;
}

.subtitle {
  font-size: 13px;
  color: #b3b3b3;
  font-family: 'Hiragino Sans', sans-serif;
}

form {
  display: flex;
  flex-direction: column;
  gap: 12px; 
}

label {
  font-weight: bold;
  font-size: 13px; 
  color: #ffe900;
}

input,
select {
  width: 100%;
  padding: 10px; 
  border: 1px solid #444;
  border-radius: 4px;
  font-size: 15px;
  background: rgba(255, 255, 255, 0.1);
  color: white;
}

input::placeholder {
  color: #ccc;
}

.name-container {
  display: flex;
  gap: 12px; 
}

.name-field {
  flex: 1;
}

.location-container {
  display: flex;
  gap: 12px; 
}

.location-field {
  flex: 1;
}

.options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13px;
}

.forgot-password {
  color: #fe4a49;
  text-decoration: none;
}

.terms {
  font-size: 11px;
  color: #ccc;
}

.btn-signin {
  background: #ffe900;
  color: #050517;
  padding: 10px;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease;
}

.btn-signin:hover {
  background: #e6d100;
}

@media (max-width: 900px) {
  .login-container {
    flex-direction: column;
    width: 100%;
    max-width: 400px;
    padding: 20px;
  }

  .login-left {
    display: none;
  }

  .login-right {
    width: 100%;
    padding: 20px;
  }

  input,
  select {
    font-size: 14px;
    padding: 8px; 
  }

  .btn-signin {
    padding: 8px; 
    font-size: 14px; 
  }
}
</style>