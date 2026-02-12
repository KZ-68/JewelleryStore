<script setup lang="ts">
import axios from 'axios'
import type { Product } from '@/types/product'
import { Category } from '@/types/category';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue'
import { onMounted, ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';;

interface ProductsListProps {
    classname:string
    product: Product
    frontCategories: Category[]
    cartProductsCount: number
    price:number
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<ProductsListProps>()

const retailPrice = ref(0);

async function addToCart(product:Product, quantity: number, retailPrice: number) {
    try {
        await axios.post(
            route('cart.addToCart', {product : product, quantity: quantity, retail_price: retailPrice}, false, Ziggy)
        )
    } catch (error) {
        console.error('Erreur:', error);
    }
}
</script>

<template>
    <ShopHeader :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
    <main id="shop-product-page-main" class="px-24 py-8 bg-gray-100">
        <section id="shop-product-page-wrapper">
            <div id="shop-product-page-header" class="flex flex-col gap-2 my-4 mx-2">
                <h1 class="text-3xl">Product Page</h1>
            </div>
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="flex flex-row flex-nowrap mx-4">
                        <div class="flex-1 px-4">
                            <div x-data="{ image: 1 }" x-cloak>
                                <div class="h-64 md:h-80 rounded-lg bg-gray-100 mb-4">
                                    <div x-show="image === 1" class="h-64 md:h-80 rounded-lg bg-gray-100 mb-4 flex items-center justify-center">
                                        <span class="text-5xl">1</span>
                                    </div>

                                    <div x-show="image === 2" class="h-64 md:h-80 rounded-lg bg-gray-100 mb-4 flex items-center justify-center">
                                        <span class="text-5xl">2</span>
                                    </div>

                                    <div x-show="image === 3" class="h-64 md:h-80 rounded-lg bg-gray-100 mb-4 flex items-center justify-center">
                                        <span class="text-5xl">3</span>
                                    </div>

                                    <div x-show="image === 4" class="h-64 md:h-80 rounded-lg bg-gray-100 mb-4 flex items-center justify-center">
                                        <span class="text-5xl">4</span>
                                    </div>
                                </div>

                                <div class="flex -mx-2 mb-4">
                                    <template x-for="i in 4">
                                        <div class="flex-1 px-2">
                                            <button x-on:click="image = i" :class="{ 'ring-2 ring-indigo-300 ring-inset': image === i }" class="focus:outline-none w-full rounded-lg h-24 md:h-32 bg-gray-100 flex items-center justify-center">
                                                <span x-text="i" class="text-2xl"></span>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="flex-1 px-4">
                                <h2 class="mb-2 leading-tight tracking-tight font-bold text-gray-800 text-2xl md:text-3xl">{{ product.name }}</h2>
                                <p class="text-gray-500 text-sm">By <a href="#" class="text-indigo-600 hover:underline"></a></p>

                                <div class="flex items-center space-x-4 my-4">
                                    <div>
                                        <div class="rounded-lg bg-gray-100 flex py-2 px-3">
                                        <span class="text-indigo-400 mr-1 mt-1">€</span>
                                        <span class="font-bold text-indigo-600 text-3xl">{{ props.price }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-400 text-sm">Inclusive of all Taxes.</p>
                                    </div>
                                </div>

                                <p class="text-gray-500">{{ product.description }}</p>

                                <div class="flex py-4 space-x-4">
                                    <div class="relative">
                                        <div class="text-center left-0 pt-2 right-0 absolute block text-xs uppercase text-gray-400 tracking-wide font-semibold">Qty</div>
                                        <select class="cursor-pointer appearance-none rounded-xl border border-gray-200 pl-4 pr-8 h-14 flex items-end pb-1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>

                                        <svg class="w-5 h-5 text-gray-400 absolute right-0 bottom-0 mb-2 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                        </svg>
                                    </div>

                                    <button @click="addToCart(props.product, 1, retailPrice)" type="button" class="h-14 px-6 py-2 font-semibold rounded-xl bg-red-900 hover:bg-red-700 text-white">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="shop-product-page-footer" class="my-4"></div>
        </section>
    </main>
</template>