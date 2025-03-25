<template>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-brand">
                <a class="navbar-item" href="/">
<<<<<<< HEAD
                    <img src="" alt="Logo">
=======
                    <img src="@/assets/images/logonxticket.png" alt="Event Image" class="image-logo" />
>>>>>>> 6f75e95 (vistas nuevas)
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
<<<<<<< HEAD
=======

.image-logo{
    width:100px;
    height:80px;
}
>>>>>>> 6f75e95 (vistas nuevas)
</style>