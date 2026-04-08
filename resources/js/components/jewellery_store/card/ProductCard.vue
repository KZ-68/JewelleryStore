<script setup lang="ts">
import axios from 'axios'
import type { Product } from '@/types/product'
import { inject, onMounted, Ref, ref } from "vue";
import { ShoppingCart } from 'lucide-vue-next';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../ziggy.js';

interface ProductCardProps {
    classname:string
    product: Product
    image: null|string
    sortBy: string
    order: 'asc' | 'desc'
    locale: string
}

const retailPrice = ref(0);
const openCartModalValue = inject<Ref<boolean>>('openCartModalValue');

const props = defineProps<ProductCardProps>()

async function addToCart(product:Product, quantity: number, retailPrice: number) {
    try {
        await axios.post(
            route('cart.addToCart', {locale: props.locale, product : product, quantity: quantity, retail_price: retailPrice}, false, Ziggy)
        )
    } catch (error) {
        console.error('Erreur:', error);
    }
    openCartModalValue.value = true;
}

onMounted(async () => {
    try {
        await axios.post(
            route('products.shopRetailPrice', {locale: props.locale, slug : props.product.slug}, false, Ziggy), {locale: props.locale, slug : props.product.slug}
        ).then(response => {
            retailPrice.value = response.data.price
        })
    } catch (error) {
        console.error('Erreur:', error);
    }
})

defineEmits(['addProduct', 'addProductQuantity', 'addProductPrice']);
</script>

<template>
    <div class="relative grow max-w-[16rem] bg-white inline-flex flex-col px-2 pb-2 min-w-[9rem] lg:min-w-[16rem] box-border shadow-md rounded-lg">
        <div class="absolute top-[4px] right-[4px] w-[28px] h-[28px] text-center z-10 rounded-full">
            <div>
                <span class="absolute top-[4px] right-[4px] w-[24px] h-[24px] text-center z-10 rounded-full bg-gray-200">
                    <div class="absolute top-0 left-0 right-0 bottom-0 m-auto">
                    
                    </div>
                </span>
            </div>
        </div>

        <div class="relative min-w-[9rem] lg:min-w-full min-h-60 flex flex-col">
            <div class="relative rounded-t-lg w-full h-full bg-white overflow-hidden"> 
                <a :href="route('products.showShopProduct', {locale: props.locale,slug: props.product.slug}, false, Ziggy)" class="relative inline-flex items-stretch w-full h-full p-0">
                    <div class="flex flex-row justify-center my-0 mx-auto w-full h-full">
                        <figure class="flex justify-center py-2 items-center w-3/4 lg:w-full">
                            <img :src="props.image ? props.image : '/storage/img/p/not-found.jpg'" alt="Jewellery Product Image">
                        </figure>
                    </div>
                </a>
            </div>
            <div id="product-card-footer" class="relative inline-flex flex-row justify-around items-center gap-3 mx-2">
                <div class="relative w-fit p-3">
                    <a :href="route('products.showShopProduct', {locale: props.locale,slug: props.product.slug}, false, Ziggy)" class="text-gray-800 max-h-[38px] text-sm font-semibold">
                        {{ props.product.name }}
                    </a>
                    <div class="text-sm w-fit font-bold text-amber-700">
                        {{ retailPrice }}
                    </div>
                </div>
                <div id="add-cart-button" class="w-[42px] bg-[#84070F] z-10 rounded-full py-0.5 px-0.5">
                    <button aria-label="addToCart" :value="retailPrice" type="button" role="button" @click="addToCart(props.product, 1, retailPrice); $emit('addProduct', props.product); $emit('addProductQuantity', 1); $emit('addProductPrice', props.product.retail_price);" class="text-white m-1.5 cursor-pointer"><ShoppingCart /></button>
                </div>
            </div>
        </div>
    </div>
</template>