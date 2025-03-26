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
    console.log("Login successful:", response);
    return response.data;
  } catch (error) {
    console.error("Login error:", error);
    throw error.response?.data?.message || "Login failed. Please check your credentials.";
  }
}
