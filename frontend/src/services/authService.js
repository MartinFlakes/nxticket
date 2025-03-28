import api from '@/api';

export async function registerUser(userData) {
  try {
    const response = await api.post('/register', userData);
    console.log("Registro exitoso:", response);

    // Intentar iniciar sesión automáticamente después del registro
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

    // Depuración: Verifica la respuesta del backend
    console.log("Respuesta del servidor:", response);

    // Validar que la respuesta contenga los datos esperados
    if (!response.data || !response.data.user || !response.data.access_token) {
      throw new Error("La respuesta del servidor no contiene los datos esperados.");
    }

    const { access_token, user } = response.data;

    // Validar que el usuario tenga un role_id
    if (!user.role_id) {
      throw new Error("El usuario no tiene un role_id definido.");
    }

    // Almacenar datos en localStorage
    localStorage.setItem('access_token', access_token);
    localStorage.setItem('role_id', user.role_id);
    localStorage.setItem('user_id', user.id);
    localStorage.setItem('name', user.name);
    localStorage.setItem('email', user.email);
    localStorage.setItem('isLoggedIn', true);

    // Disparar evento de cambio de autenticación
    window.dispatchEvent(new Event('auth-changed'));

    console.log("Login exitoso:", response.data);

    return response.data;
  } catch (error) {
    console.error("Login error:", error);

    // Manejo de errores: Mostrar mensaje claro
    const errorMessage = error.response?.data?.message || "Error al iniciar sesión. Inténtalo de nuevo.";
    throw new Error(errorMessage);
  }
}

export function logoutUser() {
  // Eliminar datos del localStorage
  localStorage.removeItem('access_token');
  localStorage.removeItem('role_id');
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('user_id');
  localStorage.removeItem('name');
  localStorage.removeItem('email');

  // Disparar evento de cambio de autenticación
  window.dispatchEvent(new Event('auth-changed'));
}

export function isAuthenticated() {
  // Verificar si el token de acceso existe
  return !!localStorage.getItem('access_token');
}

export function isAdmin() {
  // Verificar si el usuario tiene el rol de administrador
  const role = localStorage.getItem('role_id');
  return role === '1';
}

export function isUser() {
  // Verificar si el usuario tiene el rol de usuario
  const role = localStorage.getItem('role_id');
  return role === '2';
}