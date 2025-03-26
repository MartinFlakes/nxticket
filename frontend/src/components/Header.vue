<template>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-brand">
                <a class="navbar-item" href="/">
                    <img src="@/assets/images/logonxticket.png" alt="Event Image" class="image-logo" />
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-start">
                    <a v-if="!isLoggedIn" class="navbar-item" href="/login">Iniciar Sesión</a>
                    <a v-else class="navbar-item" href="/account">Mi Cuenta</a>
                    <a v-if="isLoggedIn" class="navbar-item logout" @click="logout">Cerrar Sesión</a>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import { isAuthenticated, logoutUser } from '@/services/authService';

export default {
    data() {
        return {
            isLoggedIn: isAuthenticated()  // Inicializar con el estado actual
        };
    },
    mounted() {
        // Listener para detectar cambios en localStorage
        window.addEventListener("storage", this.syncAuthState);
    },
    beforeUnmount() {
        window.removeEventListener("storage", this.syncAuthState);
    },
    methods: {
        // Sincronizar el estado de autenticación
        syncAuthState() {
            this.isLoggedIn = isAuthenticated();
        },
        logout() {
            logoutUser();
            this.isLoggedIn = false;  // Actualizar estado
            this.$router.push('/login');
        }
    }
};
</script>

<style scoped>
.header {
    color: #fff;
    padding: 0.5rem;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-item {
    color: #fff;
    text-decoration: none;
    margin: 1rem;
}

.navbar-item:hover {
    text-decoration: underline;
}

.image-logo {
    width: 100px;
}

.logout {
    cursor: pointer;
    color: red;
}
</style>
