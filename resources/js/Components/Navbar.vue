<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <router-link to="/" class="navbar-brand">
                Square Payment
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link active" aria-current="page">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">Profile</router-link>
                    </li>
                    <li class="nav-item">
                       <!-- call logout api -->
                        <a href="#" class="nav-link" @click="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>    
    export default {
        name: 'Navbar',
        methods: {
            logout() {
                localStorage.removeItem('user-token');
                axios.post('/logout').then(response => {
                    window.location.href = '/';
                });
            },
        },
    };
</script>