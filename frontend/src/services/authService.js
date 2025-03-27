import api from '@/api';

export async function registerUser(userData) {
  try {
      const response = await api.post('/register', userData);
      console.log("Registro exitoso:", response);

      const loginResponse = await loginUser({
          email: userData.email,
          password: userData.password,
      });
      console.log("Login después del registro exitoso:", loginResponse);

      return loginResponse; 
  } catch (error) {
      console.error("Error en el registro:", error);
      throw error.response?.data?.message || "Registro fallido. Intenta nuevamente.";
  }
}

export async function loginUser(credentials) {
  try {
      const response = await api.post('/login', credentials);
      
      const { access_token, user } = response.data; 
      localStorage.setItem('access_token', access_token);  
      localStorage.setItem('role_id', user.role_id);  
      localStorage.setItem('user_id', user.id); 
      localStorage.setItem('name', user.name);  
      localStorage.setItem('email', user.email); 
      localStorage.setItem('email_verified_at', user.email_verified_at);  
      localStorage.setItem('created_at', user.created_at);  
      localStorage.setItem('updated_at', user.updated_at); 
      localStorage.setItem('isLoggedIn', true); 
      window.dispatchEvent(new Event('auth-changed'));  
      console.log("Login exitoso:", response.data);  

      return response.data; 
  } catch (error) {
      console.error("Login error:", error);
      throw error.response?.data?.message || "Error al iniciar sesión. Inténtalo de nuevo.";
  }
}


// Cerrar sesión
export function logoutUser() {
    localStorage.removeItem('access_token');  
    localStorage.removeItem('role_id');  
    window.dispatchEvent(new Event('auth-changed'));  

}


// Obtener el rol del usuario
export function getUserRole() {
  return localStorage.getItem('role_id'); 
}

// authService.js

export function isAuthenticated() {
  return !!localStorage.getItem('access_token');  
}

export function isAdmin() {
  const role = localStorage.getItem('role_id'); 
  console.log('Rol de usuario desde localStorage: ', role); 
  return role === '1';  
}

export function isUser() {
  const role = localStorage.getItem('role_id');
  return role === '2';  
}


