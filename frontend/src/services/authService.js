import api from '@/api';

// Registrar un usuario
export async function registerUser(userData) {
  try {
      // 1. Realizar la petición para registrar al usuario
      const response = await api.post('/register', userData);
      console.log("Registro exitoso:", response);

      // 2. Luego, hacemos login automáticamente con las mismas credenciales
      const loginResponse = await loginUser({
          email: userData.email,
          password: userData.password,
      });
      console.log("Login después del registro exitoso:", loginResponse);

      return loginResponse; // Devuelve los datos de login (puedes usar estos datos en tu UI)
  } catch (error) {
      console.error("Error en el registro:", error);
      throw error.response?.data?.message || "Registro fallido. Intenta nuevamente.";
  }
}

export async function loginUser(credentials) {
  try {
      const response = await api.post('/login', credentials);
      
      const { access_token, user } = response.data; 
      localStorage.setItem('access_token', access_token);  // Guardar token
      localStorage.setItem('role_id', user.role_id);  // Guardar el rol del usuario
      localStorage.setItem('admin', user.admin);  // Guardar si es admin o no
      localStorage.setItem('isLoggedIn', true);  // Guarda el estado de login
      window.dispatchEvent(new Event('auth-changed'));  // Emite el evento
      console.log("Login exitoso:", response.data);  // Depura los datos de usuario

      return response.data; // Devuelve los datos de usuario para manejar si es admin o no
  } catch (error) {
      console.error("Login error:", error);
      throw error.response?.data?.message || "Error al iniciar sesión. Inténtalo de nuevo.";
  }
}



// Cerrar sesión
export function logoutUser() {
    localStorage.removeItem('access_token');  // Eliminar token
    localStorage.removeItem('role_id');  // Eliminar rol
    window.dispatchEvent(new Event('auth-changed'));  // Emite el evento

}


// Obtener el rol del usuario
export function getUserRole() {
  return localStorage.getItem('role_id');  // Retorna el role_id como string
}

// authService.js

export function isAuthenticated() {
  return !!localStorage.getItem('access_token');  // Verifica si hay un token
}

export function isAdmin() {
  const role = localStorage.getItem('role_id'); // Esto será '2' para usuario, '1' para admin
  console.log('Rol de usuario desde localStorage: ', role);  // Depura el valor del rol
  return role === '1';  // Verifica si el rol es '1' (admin)
}

export function isUser() {
  const role = localStorage.getItem('role_id');
  return role === '2';  // Verifica si el rol es '2' (usuario normal)
}


