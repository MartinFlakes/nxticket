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
    margin: 1 1rem;
}

.navbar-item:hover {
    text-decoration: underline;
}

.image-logo{
    width:100px;
}
</style>