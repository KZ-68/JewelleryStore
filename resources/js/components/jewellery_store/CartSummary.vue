<script setup lang="ts">
import { Ziggy } from '@/ziggy'
import { route } from '../../../../vendor/tightenco/ziggy/src/js'


interface CartProduct {
    product_id: number
    name: string
    quantity: number
    price : number
}

interface CartSummaryProps {
    products: Array<CartProduct>
    sub_total_price: number
    defaultShippingRatePrice: number
    locale: string
}

const props = defineProps<CartSummaryProps>()
const total_price = props.sub_total_price + props.defaultShippingRatePrice
</script>

<template>
    <section id="cart-summary" class="h-full w-1/4 my-10 px-8 pt-20 pb-10 bg-white rounded-lg">
        <h1 class="font-semibold text-2xl border-b pb-8">Cart Summary</h1>
        
        <div id="cart-promo-code" class="my-10">
          <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">Promo Code</label>
          <input type="text" id="promo" placeholder="Enter your code" class="p-2 text-sm w-full">
        </div>
        
        <button class="bg-red-900 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">Apply</button>
        
        <div id="total-cost-wrapper" class="border-t mt-8">
          <div class="flex gap-3 font-semibold my-4 text-sm uppercase">
            <h3>Sub Total :</h3>
            <span v-if="props.sub_total_price && props.sub_total_price !== 0">{{ props.sub_total_price }}</span>
            <span v-else>0</span>
          </div>
          <div id="shipping-section" class="flex gap-3 font-semibold my-4 text-sm uppercase">
            <h3>Shipping Cost: </h3>
            <span v-if="defaultShippingRatePrice">{{ defaultShippingRatePrice }}</span>
            <span v-else>0</span>
          </div>
          <div class="flex gap-3 font-semibold my-4 text-sm uppercase">
            <h3>Total cost :</h3>
            <span v-if="total_price && total_price !== 0">{{ total_price }}</span>
            <span v-else>0</span>
          </div>
        </div>

        <a :class="props.sub_total_price === 0 ? 'opacity-50 cursor-not-allowed' : ''" id="checkout-access" class="bg-indigo-600 text-white font-bold my-4 py-4 px-8" :href=" props.sub_total_price === 0 ? '#' : route('order.showOrderPage', {locale: props.locale}, false, Ziggy)">Checkout</a>
    </section>
</template>