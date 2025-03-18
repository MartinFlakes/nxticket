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

        <form @submit.prevent="isSignUp ? register : login">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" placeholder="Enter your email" required />

          <label for="password">Password</label>
          <div class="password-container">
            <input :type="showPassword ? 'text' : 'password'" id="password" v-model="password" placeholder="Enter your password" required />
          </div>

          <div v-if="isSignUp">
            <div class="name-container">
              <div class="name-field">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" v-model="firstName" placeholder="Enter your first name" required />
              </div>
              <div class="name-field">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" v-model="lastName" placeholder="Enter your last name" required />
              </div>
            </div>

            <div class="location-container">
              <div class="location-field">
                <label for="country">Country of Residence</label>
                <select id="country" v-model="country" required>
                  <option value="United States">United States</option>
                </select>
              </div>
              <div class="location-field">
                <label for="zip">Zip/Postal Code</label>
                <input type="text" id="zip" v-model="zip" placeholder="Enter your zip code" required />
              </div>
            </div>
          </div>

          <div class="options">
            <a href="#" class="forgot-password" v-if="!isSignUp">Forgot Password?</a>
          </div>

          <p class="terms">
            By continuing, you agree to the <a href="#">Terms of Use</a> and our <a href="#">Privacy Policy</a>.
          </p>

        <button type="submit" class="btn-signin" @click.prevent="login">
          {{ isSignUp ? 'Next' : 'Sign In' }}
        </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isSignUp: false, 
      email: '',
      password: '',
      firstName: '',
      lastName: '',
      country: 'United States',
      zip: '',
      showPassword: false,
    };
  },
  methods: {
    login() {
      if (this.email && this.password) {
    
    this.$router.push({ name: 'user' }).catch(err => console.error("Error de navegación:", err));

      } else {
        alert("Por favor, ingresa tu correo y contraseña.");
      }
    },
    register() {
      if (this.email && this.password && this.firstName && this.lastName && this.country && this.zip) {
        alert("Registro exitoso. Ahora puedes iniciar sesión.");
        this.isSignUp = false; // Cambiar al formulario de inicio de sesión
      } else {
        alert("Por favor, completa todos los campos.");
      }
    },
    toggleForm() {
      this.isSignUp = !this.isSignUp;
    }
  },
  mounted() {
    const query = this.$route.query;
    if (query.signup === 'true') {
      this.isSignUp = true; // Activar el formulario de registro
    }
  }
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