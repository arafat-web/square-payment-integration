<template>
    <div>
        <Navbar />
        <div class="container">
            <h1 class="text-center py-5">Order Confirmation</h1>
            <div class="row">
                <div class="col-md-6">
                    <div v-if="product" class="card shadow-sm border-0">
                        <img :src="product.image" :alt="product.name" class="card-img-top">
                        <div class="card-body">
                            <h3 class="card-title">{{ product.name }}</h3>
                            <p class="card-text">{{ product.description }}</p>
                            <h4>Price: ${{ product.price }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header">
                            <h3 class="card-title">Price Summary</h3>
                        </div>
                        <div v-if="product" class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Base Price: ${{ product.price }}</li>
                                <li class="list-group-item">Tax (10%): ${{ (product.price * 0.1).toFixed(2) }}</li>
                                <li class="list-group-item">Total: ${{ (product.price * 1.1).toFixed(2) }}</li>
                            </ul>
                            <form @submit.prevent="handlePayment">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Pay ${{ (product.price *
                        1.1).toFixed(2) }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Navbar from "../Components/Navbar.vue";
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute } from 'vue-router';


const product = ref(null);
const route = useRoute();

onMounted(async () => {
    await fetchProduct();
});

async function fetchProduct() {
    try {
        const response = await axios.get(`/product/${route.params.id}`);
        product.value = response.data.product;
    } catch (error) {
        console.error("Failed to fetch product:", error);
    }
}


async function handlePayment() {
    try {
        await axios.post('/payments', {
            nonce: 'cnon:card-nonce-ok',
            amount: Math.round(product.value.price * 1.1 * 100), // Amount in cents
            order_id: 1
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('user-token')
            }
        });
        alert('Payment Successful!');
    } catch (error) {
        console.error('Error processing payment:', error);
        alert('Payment Failed!');
    }
}
</script>

<style scoped>
.card-img-top {
    width: 100%;
    object-fit: cover;
    height: 300px;
}

.list-group-item {
    background-color: transparent;
    border: none;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

#card-container {
    margin-bottom: 10px;
}
</style>