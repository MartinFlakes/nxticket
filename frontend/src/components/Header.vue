<template>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-brand">
                <a class="navbar-item" href="/">
                    <img src="" alt="Logo">
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item" href="/login">Iniciar Session</a>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: 'Header'
}
</script>

<style scoped>
.header {
    color: #fff;
    padding: 1rem;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-item {
    color: #fff;
    text-decoration: none;
    margin: 0 1rem;
}

.navbar-item:hover {
    text-decoration: underline;
}
</style>