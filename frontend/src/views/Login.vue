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
          <div v-if="isSignUp" class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" v-model="name" placeholder="Enter your full name" required />
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="email" placeholder="Enter your email" required />
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="password-container">
              <input :type="showPassword ? 'text' : 'password'" id="password" v-model="password" placeholder="Enter your password" required />
            </div>
          </div>

          <div v-if="isSignUp" class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" v-model="password_confirmation" placeholder="Confirm your password" required />
          </div>

          <div v-if="passwordError" class="error-message">{{ passwordError }}</div>
          <button type="submit" class="btn-signin">
            {{ isSignUp ? 'Register' : 'Sign In' }}
          </button>
        </form>

        <div v-if="user" class="welcome-user">
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
      passwordError: '',
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
      if (this.password.trim() !== this.password_confirmation.trim()) {
        this.passwordError = "Las contraseñas no coinciden.";
        return;
      }

      this.passwordError = '';
      const userData = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
      };

      try {
        const response = await registerUser(userData);
        const { access_token, user } = response;

        localStorage.setItem('access_token', access_token);
        localStorage.setItem('user', JSON.stringify(user));

        this.user = user;

        const redirectPath = this.$route.query.redirect || '/';
        this.$router.replace(redirectPath);
      } catch (error) {
        alert(error || "Hubo un error al registrar.");
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

    const { access_token, user } = response;

    if (!user.role_id) {
      console.error("El usuario no tiene un role_id definido.");
      alert("Hubo un problema con los datos del usuario. Contacta al administrador.");
      return;
    }

    localStorage.setItem('access_token', access_token);
    localStorage.setItem('user', JSON.stringify(user));

    this.user = user;

    console.log("user.role_id:", user.role_id);

    const redirectPath = this.$route.query.redirect || (user.role_id !== 'admin' ? '/' : '/admin/dashboard');
    
    console.log("Redirect path:", redirectPath);
    
    this.$router.replace(redirectPath);

  } catch (error) {
    alert(error || "Hubo un error en el inicio de sesión.");
  }
},


    toggleForm() {
      this.isSignUp = !this.isSignUp;
      this.passwordError = '';
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
  min-height: 100vh;
  padding: 2rem;
  background: linear-gradient(135deg, #01569a, #050517); /* #01569a como principal */
  font-family: 'Kanit', sans-serif;
  position: relative;
  overflow: hidden;
}

.login-wrapper::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(1, 86, 154, 0.3), transparent 70%); /* #01569a tenue */
  animation: pulse 15s infinite ease-in-out;
  z-index: 0;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.5; }
  50% { transform: scale(1.1); opacity: 0.8; }
}

.login-container {
  display: flex;
  width: 100%;
  max-width: 1000px;
  border-radius: 16px;
  overflow: hidden;
  background: rgba(1, 86, 154, 0.9); /* #01569a como base */
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4), inset 0 0 10px rgba(255, 233, 0, 0.2); /* Toque de #ffe900 */
  position: relative;
  z-index: 1;
  border: 2px solid #ffe900;
}

.login-left {
  width: 40%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(5, 5, 23, 0.8); 
  position: relative;
}

.welcome-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 16px 0 0 16px;
  transition: transform 0.3s ease;
}

.welcome-image:hover {
  transform: scale(1.05);
}

/* Lado Derecho (Formulario) */
.login-right {
  width: 60%;
  padding: 3rem;
  color: #ffffff;
  position: relative;
}

h2 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  color: #ffe900; /* Amarillo como acento */
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(1, 86, 154, 0.7); 
  animation: glow 2s infinite alternate;
}

@keyframes glow {
  0% { text-shadow: 0 0 10px rgba(1, 86, 154, 0.7), 0 0 20px rgba(255, 233, 0, 0.5); }
  100% { text-shadow: 0 0 15px rgba(1, 86, 154, 0.9), 0 0 30px rgba(255, 233, 0, 0.7); }
}

.subtitle {
  font-size: 1rem;
  color: #ccc;
  font-family: 'Hiragino Sans', sans-serif;
  margin-bottom: 2rem;
}

.subtitle a {
  color: #ffe900;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s ease;
}

.subtitle a:hover {
  color: #e6d100;
}

/* Formulario */
form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  position: relative;
}

label {
  font-weight: 500;
  font-size: 1.1rem;
  color: #ddd; 
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 0.5rem;
  font-family: 'Kanit', sans-serif;
}

input {
  width: 100%;
  padding: 1rem;
  border: 2px solid rgba(1, 86, 154, 0.5); 
  border-radius: 10px;
  font-size: 1rem;
  background: rgba(5, 5, 23, 0.3);
  color: #ffffff;
  transition: all 0.3s ease;
  box-shadow: inset 0 0 5px rgba(1, 86, 154, 0.3);
  font-family: 'Hiragino Sans', sans-serif;
}

input::placeholder {
  color: #ccc;
  opacity: 0.8;
}

input:focus {
  border-color: #ffe900; 
  background: rgba(5, 5, 23, 0.5);
  box-shadow: 0 0 12px rgba(1, 86, 154, 0.7); 
  transform: scale(1.02);
  outline: none;
}

/* Mensaje de Error */
.error-message {
  color: #fe4a49;
  font-size: 0.9rem;
  margin-top: -1rem;
  margin-bottom: 1rem;
  font-family: 'Hir-Font agino Sans', sans-serif;
}

/* Opciones */
.options {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 1rem;
}

.forgot-password {
  color: #ffe900; 
  text-decoration: none;
  font-size: 0.9rem;
  transition: color 0.3s ease;
}

.forgot-password:hover {
  color: #e6d100;
}

/* Términos */
.terms {
  font-size: 0.85rem;
  color: #ccc;
  font-family: 'Hiragino Sans', sans-serif;
  margin-bottom: 1.5rem;
}

.terms a {
  color: #ffe900;
  text-decoration: none;
  transition: color 0.3s ease;
}

.terms a:hover {
  color: #e6d100;
}

.btn-signin {
  background: #01569a;
  color: #ffffff;
  padding: 1.2rem;
  border: 2px solid #ffe900;
  border-radius: 12px;
  font-size: 1.2rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-family: 'Kanit', sans-serif;
}

.btn-signin::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255, 233, 0, 0.3);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s ease, height 0.6s ease;
}

.btn-signin:hover::before {
  width: 300px;
  height: 300px;
}

.btn-signin:hover {
  background: #024077;
  box-shadow: 0 0 20px rgba(1, 86, 154, 0.8);
  transform: translateY(-3px);
  color: #ffe900; 
}

.welcome-user p {
  font-size: 1.2rem;
  color: #ffe900;
  margin-top: 2rem;
  font-family: 'Kanit', sans-serif;
  text-shadow: 0 0 5px rgba(1, 86, 154, 0.5);
}

@media (max-width: 900px) {
  .login-wrapper {
    padding: 1rem;
  }

  .login-container {
    flex-direction: column;
    max-width: 400px;
    padding: 0;
  }

  .login-left {
    display: none;
  }

  .login-right {
    width: 100%;
    padding: 2rem;
  }

  h2 {
    font-size: 2rem;
  }

  .btn-signin {
    padding: 1rem;
    font-size: 1rem;
  }
}
</style>