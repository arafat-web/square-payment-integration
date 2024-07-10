<template>
    <Navbar />
    <div class="home">
        <div class="container">
            <h3 class="text-center p-4">Product List </h3>
            <div class="row">
                <div class="col-md-4 mb-4" v-for="product in products" :key="product.id">
                    <div class="card text-center border-0 shadow-sm">
                        <img :src="product.image" class="card-img-top" style="height: 300px" :alt="product.name">
                        <div class="card-body">
                            <h5 class="card-title">{{ product.name }}</h5>
                            <p class="card-text"> $ {{ product.price }}</p>
                            <p class="card-text text-muted small">{{ product.description }}</p>
                            <router-link :to="`/order/confirmation/${product.id}`" class="btn btn-primary">Buy Now</router-link>
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

const response = ref();
const products = ref([]);

onMounted(() => {
    getProducts();
});

const getProducts = async () => {
    try {
        response.value = await axios.get("/products");
        if (response.value.data) {
            products.value = response.value.data.products;
        }
    } catch (error) {
        console.error(error);
    }
};

const getValue = async () => {
    try {
        response.value = await axios.get("/test-me");
    } catch (error) {
        console.error(error);
    }
};
</script>

<style scoped>
.navbar-brand img {
    margin-right: 10px;
}
</style>
