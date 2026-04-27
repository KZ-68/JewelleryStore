<script setup lang="ts">
import { useTrans } from '@/composables/trans'


interface CartProduct {
    name: string
    quantity: number
    price : number
}

interface OrderSummaryProps {
    products: Array<CartProduct>
    total_price: number
    shipping_cost: number
}

const props = defineProps<OrderSummaryProps>()
</script>

<template>
    <section id="summary" class="w-full lg:w-1/4 my-6 lg:my-10 px-8 pt-10 lg:pt-20 pb-10 bg-white rounded-bl-lg">
        <h1 class="font-semibold text-2xl border-b pb-8">{{ useTrans('Order Summary') }}</h1>
        <div v-for="product in products" :key=product.name class="flex justify-between mt-10 mb-5">
          <span class="font-semibold text-sm uppercase">{{ useTrans(product.name) }}</span>
          <span class="font-semibold text-sm">x{{product.quantity}}</span>
        </div>
        <div id="shipping-section" class="flex justify-between my-10">
          <label class="font-medium inline-block mb-3 text-sm uppercase">{{ useTrans('Shipping') }}</label>
          <span v-if="props.shipping_cost > 0" class="font-semibold text-sm">{{ props.shipping_cost }} €</span>
          <span v-else class="font-semibold text-sm text-green-600">{{ useTrans('Free') }}</span>
        </div>
        <div class="my-10">
          <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">{{ useTrans('Promo Code') }}</label>
          <input type="text" id="promo" placeholder="Enter your code" class="p-2 text-sm w-full">
        </div>
        <button class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">{{ useTrans('Apply') }}</button>
        <div class="border-t mt-8">
          <div class="flex font-semibold justify-between py-6 text-sm uppercase">
            <h2>{{ useTrans('Total cost :') }}</h2>
            <span v-if="props.total_price && props.total_price !== 0">{{ props.total_price }}</span>
            <span v-else>0</span>
          </div>
        </div>
    </section>
</template>