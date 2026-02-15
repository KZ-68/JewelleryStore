<script setup lang="ts">
import axios from 'axios'
import type { Product } from '@/types/product'
import { Category } from '@/types/category';
import { Navigation } from 'swiper/modules';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue'
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { onMounted, ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';;

interface ProductsListProps {
    classname:string
    product: Product
    frontCategories: Category[]
    cartProductsCount: number
    price:number
    productImages: string[]
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
        <section id="shop-product-page-main-wrapper">
            <div id="shop-product-page-header" class="flex flex-col gap-2 my-4 mx-2">
                <h1 class="text-3xl">Product Page</h1>
            </div>
            <div class="py-6">
                <div class="max-w-[88rem] mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="flex flex-row flex-nowrap justify-evenly mx-4">
                        <div id="shop-product-page-images-wrapper" class="relative w-xl flex flex-col gap-8 pl-16 pr-8">
                            <div class="w-[450px] h-[450px] mb-4">
                                <div class="w-[450px] h-[450px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                    <span class="text-5xl">1</span>
                                </div>
                            </div>
                            
                            <div id="shop-product-page-images-swipper-wrapper" class="flex flex-row justify-around">
                                <swiper :navigation="true" :modules="[Navigation]" :slides-per-view="3" :space-between="1" id="mySwiper">
                                    <swiper-slide v-for="image in productImages" :key=image>
                                        <figure class="w-[128px] lg:h-[128px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                            <img :src="image" class="w-[128px] lg:h-[128px] rounded-lg" />
                                        </figure>
                                    </swiper-slide>
                                </swiper>
                            </div>
                        </div>

                        <div class="px-4">
                            <h2 class="mb-2 leading-tight tracking-tight font-bold text-gray-800 text-2xl md:text-3xl">{{ product.name }}</h2>
                            <p class="text-gray-500 text-sm">By <a href="#" class="text-red-900 hover:underline"></a></p>

                            <div class="flex items-center space-x-4 my-4">
                                <div>
                                    <div class="rounded-lg bg-gray-100 flex">
                                    <span class="font-bold text-red-900 text-3xl">{{ props.price }}</span>
                                    <span class="text-red-800 ml-2 mt-1">€</span>
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
        </section>
        <section id="shop-product-page-description-wrapper" class="my-3">
            <h2 id="title-product" class="text-2xl font-bold">Description</h2>
            <div class="product-description">
                {{ product.description }}
            </div>
        </section>
        <section id="shop-product-page-footer" class="my-4"></section>
    </main>
</template>