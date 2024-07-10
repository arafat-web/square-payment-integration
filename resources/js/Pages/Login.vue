<template>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-header text-center bg-primary text-white py-5">
                    <h2>Login</h2>
                </div>
                <div class="card-body mb-5">
                    <form @submit.prevent="login">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" v-model="email"
                                placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" v-model="password"
                                placeholder="Enter your password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 mt-4">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
    data() {
        return {
            email: "",
            password: "",
        };
    },
    setup() {
        const router = useRouter();
        return { router };
    },
    methods: {
        login() {
            axios.post('/login', {
                email: this.email,
                password: this.password,
            })
                .then(response => {
                    if (response.data && response.data.token) {
                        localStorage.setItem('user-token', response.data.token);
                        this.router.push('/');
                    } else {
                        console.error('Token not provided in response');
                    }
                })
                .catch(error => {
                    console.error('Login Error:', error.response.data);
                });
        },
    },
    mounted() {
        if (localStorage.getItem('user-token')) {
            this.router.push('/');
        }
    },
};


</script>

<style scoped>
.form-label {
    font-weight: bold;
}

.btn-primary {
    background-color: #0056b3;
    border: none;
}

.btn-primary:hover {
    background-color: #004085;
}

.vh-100 {
    height: 100vh;
}
</style>
