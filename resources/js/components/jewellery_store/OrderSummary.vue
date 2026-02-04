<script setup lang="ts">

interface OrderSummaryProps {
    products: Array<object>
    product: {
        id: number
        name: string
        slug: string
        price_ht: number
    }
}

defineProps<OrderSummaryProps>()
</script>

<template>
    <section id="summary" class="h-full w-1/4 my-10 px-8 pt-20 pb-10 bg-white rounded-bl-lg">
        <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
        <div v-for="product in products" :key=product.id class="flex justify-between mt-10 mb-5">
          <span class="font-semibold text-sm uppercase">{{ product.name }}</span>
          <span class="font-semibold text-sm"></span>
        </div>
        <div id="shipping-section" class="my-10">
          <label class="font-medium inline-block mb-3 text-sm uppercase">Shipping</label>
        </div>
        <div class="my-10">
          <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">Promo Code</label>
          <input type="text" id="promo" placeholder="Enter your code" class="p-2 text-sm w-full">
        </div>
        <button class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">Apply</button>
        <div class="border-t mt-8">
          <div class="flex font-semibold justify-between py-6 text-sm uppercase">
            <h2>Total cost</h2>
            <span></span>
          </div>
        </div>
    </section>
</template>