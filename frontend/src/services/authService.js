import api from '@/api';

export async function registerUser(userData) {
  try {
    const response = await api.post('/register', userData);
    console.log("Registration successful:", response);
    return response.data;
  } catch (error) {
    console.error("Registration error:", error);
    throw error.response?.data?.message || "Registration failed. Please try again.";
  }
}

 export async function loginUser(credentials) {
    try {
      const response = await api.post('/login', credentials);
      
      const { access_token } = response.data;
       
      localStorage.setItem('access_token', access_token); // Guardar token
  
      return response.data; 
    } catch (error) {
      console.error("Login error:", error);
      throw error.response?.data?.message || "Error al iniciar sesión. Inténtalo de nuevo.";
    }
  }

export function logoutUser() {
    localStorage.removeItem('access_token');  // Eliminar token al cerrar sesión
}

export function isAuthenticated() {
    return !!localStorage.getItem('access_token');  // Retorna true si hay un token
}


