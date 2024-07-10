<template>
    <form>
      <div v-if="loading">Loading...</div>
      <div id="card-container" />
      <button>Pay $1.00</button>
    </form>
  </template>

  <script setup>
    const appId = 'sandbox-sq0idb-eXHTA1qSpfnYhWkm6F58Gg';
    const locationId = 'LH5X5K6XH5';
    import { ref, onMounted } from "vue";

    let card;
    let loading = ref(true);

    onMounted(async () => {
      loading.value = true;
      await initializePaymentForm();
      loading.value = false;
    });

    const initializePaymentForm = async () => {
      if (!Square) {
        throw new Error("Square.js failed to load properly");
      }
      const payments = Square.payments(appId, locationId);
      try {
        card = await payments.card();
        await card.attach("#card-container");
      } catch (e) {
        console.error("Initializing Card failed", e);
        return;
      }
    };
  </script>