<script setup>
import { ref, onMounted } from 'vue';
import api from './api';

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
    <div class="container">
        <h1>{{ message }}</h1>
    </div>
</template>