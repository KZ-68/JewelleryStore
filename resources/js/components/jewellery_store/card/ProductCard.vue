<script setup lang="ts">
import axios from 'axios'
import type { Product } from '@/types/product'
import { onMounted, ref } from "vue";
import { ShoppingCart } from 'lucide-vue-next';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../ziggy.js';

interface ProductCardProps {
    classname:string
    product: Product
    image: null|string
}

const retailPrice = ref(0);

const props = defineProps<ProductCardProps>()

async function addToCart(product:Product, quantity: number, retailPrice: number) {
    try {
        await axios.post(
            route('cart.addToCart', {product : product, quantity: quantity, retail_price: retailPrice}, false, Ziggy)
        )
    } catch (error) {
        console.error('Erreur:', error);
    }
}

onMounted(async () => {
    try {
        await axios.post(
            route('products.shopRetailPrice', {slug : props.product.slug}, false, Ziggy), {slug : props.product.slug}
        ).then(response => {
            retailPrice.value = response.data.price
        })
    } catch (error) {
        console.error('Erreur:', error);
    }
})
</script>

<template>
    <div class="relative grow max-w-[16rem] bg-white inline-flex flex-col px-2 pb-2 min-w-[16rem] box-border shadow-md rounded-lg">
        <a href="#" class="relative inline-flex items-stretch w-full h-full p-0">
            <div class="absolute top-[4px] right-[4px] w-[28px] h-[28px] text-center z-10 rounded-full">
                <div>
                    <span class="absolute top-[4px] right-[4px] w-[24px] h-[24px] text-center z-10 rounded-full bg-gray-200">
                        <div class="absolute top-0 left-0 right-0 bottom-0 m-auto">
                        
                        </div>
                    </span>
                </div>
            </div>

            <div class="relative min-w-full flex flex-col">
                <div class="relative">
                    <div class="relative h-0 rounded-t-lg pb-[100%] w-full bg-white text-ellipsis	overflow-hidden"> 
                        <div class="bg-no-repeat bg-cover inline-block my-0 mx-auto text-center w-full h-full absolute">
                            <figure class="flex justify-center py-2 items-center">
                                <img v-if="image == null" src="/storage/img/p/not-found.jpg" alt="Image Not Found text">
                                <img v-else src="{{'storage/img/p/'. props.product.id . '/'. props.image }}" alt="Jewellery Product Image">
                            </figure>
                        </div>
                    </div>
                </div>

                <div id="product-card-footer" class="relative inline-flex flex-row items-center gap-3 mx-2">
                    <div class="relative p-3 box-border overflow-hidden grow">
                        <span class="text-gray-800 max-h-[38px] text-sm font-semibold leading-5 overflow-hidden whitespace-normal break-words">
                            {{ props.product.name }}
                        </span>
                        <div>
                            <div class="block w-full text-sm font-bold text-amber-700">
                                {{ retailPrice }}
                            </div>
                        </div>
                    </div>
                    <div id="add-cart-button" class="w-[42px] bg-red-900 z-10 rounded-full py-0.5 px-0.5">
                        <button @click="addToCart(props.product, 1, retailPrice)" class="text-white m-1.5 cursor-pointer"><ShoppingCart /></button>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>