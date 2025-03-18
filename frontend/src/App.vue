<script setup>
import { ref, onMounted } from 'vue';
import api from './api';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import navbar from './components/navbar.vue';

const message = ref('');

onMounted(async () => {
  try {
    const res = await api.get('/test');
    message.value = res.data.message;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <Header />
  <navbar />
  <main class="container">
    <router-view />
  </main>
  <Footer />
</template>
