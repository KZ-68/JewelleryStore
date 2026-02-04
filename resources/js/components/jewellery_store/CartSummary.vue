<script setup lang="ts">
interface CartProduct {
    name: string
    quantity: number
    price : number
}

interface CartSummaryProps {
    products: Array<CartProduct>
}

const props = defineProps<CartSummaryProps>()
</script>

<template>
    <section id="cart-summary" class="h-full w-1/4 my-10 px-8 pt-20 pb-10 bg-white rounded-lg">
        <h1 class="font-semibold text-2xl border-b pb-8">Cart Summary</h1>
        <div v-if="props.products && props.products.length > 0" v-for="product in props.products" :key=product.id class="flex justify-between mt-10 mb-5">
            <span class="font-semibold text-sm uppercase">Product Name</span>
            <!-- <span class="font-semibold text-sm uppercase">{{ product.name }}</span> -->
            <span class="font-semibold text-sm"></span>
        </div>
        <div id="shipping-section" class="my-10">
          <label class="font-medium inline-block mb-3 text-sm uppercase">Shipping</label>
        </div>
        <div id="cart-promo-code" class="my-10">
          <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">Promo Code</label>
          <input type="text" id="promo" placeholder="Enter your code" class="p-2 text-sm w-full">
        </div>
        <button class="bg-red-900 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">Apply</button>
        <div id="total-cost-wrapper" class="border-t mt-8">
          <div class="flex font-semibold justify-between py-6 text-sm uppercase">
            <h2>Total cost</h2>
            <span></span>
          </div>
        </div>
        <button id="checkout-button" class="bg-indigo-600 text-white font-bold my-4 py-4 px-8">Checkout</button>
    </section>
</template>