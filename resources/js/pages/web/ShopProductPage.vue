<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import axios from 'axios'
import type { Product } from '@/types/product'
import { Category } from '@/types/category';
import { Navigation } from 'swiper/modules';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue'
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { provide, ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import { useWindowSize } from '@vueuse/core';
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import SizeSelector from '@/components/jewellery_store/select/SizeSelector.vue';

interface ProductsListProps {
    classname:string
    product: Product
    frontCategories: Category[]
    cartProductsCount: number
    price:number
    productImages: string[]
    seller_id: null|number
    seller_name: null|string
    locale: string
    feature_size_values: Array<string>
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<ProductsListProps>()

const retailPrice = ref(0);
const currentSelectedSize = ref<string>('');
const currentSelectedQuantity = ref<number>(1);

async function addToCart(product:Product, quantity: number, retailPrice: number) {
    if (currentSelectedSize.value !== '') {
        try {
            await axios.post(
                route('cart.addToCart', {locale: props.locale, product : product, quantity: quantity, retail_price: retailPrice, selected_size: currentSelectedSize.value}, false, Ziggy)
            )
        } catch (error) {
            console.error('Erreur:', error);
        }
    } else {
        
    }
}

const { width } = useWindowSize()
const active = ref<boolean>(false)
provide('active', active)
const openNav = () => {
  active.value = true
}

const activeIndex = ref(0)
function onSlideChange(swiper: any) {
  activeIndex.value = swiper.activeIndex
}

const descriptionSelected = ref(true)
const featuresSelected = ref(false)
function selectDescription() {
    descriptionSelected.value = true
}

function selectFeatures() {
    featuresSelected.value = true
    descriptionSelected.value = false
}

const selectSize = (key: string) => {
  currentSelectedSize.value = key
}
</script>

<template>
    <button v-if="width <= 430" id="openBtn" @click="openNav" class="absolute top-0 left-0 flex flex-col gap-1 p-4 bg-white z-[2]">
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
    </button>
    <ShopHeader v-if="width > 430" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale"></ShopHeader>
    <BurgerMenu v-else :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :active="active" :locale="props.locale"></BurgerMenu>
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
                                <figure v-if="props.productImages.length > 0" class="w-[450px] h-[450px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                    <img class="w-[450px] h-[450px] rounded-lg" :src="props.productImages[activeIndex]" alt="">
                                </figure>
                                <figure v-else class="w-[450px] h-[450px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                    <img class="w-[450px] h-[450px] rounded-lg" src="/storage/img/p/not-found.jpg" alt="">
                                </figure>
                            </div>
                            
                            <div v-if="productImages.length > 0" id="shop-product-page-images-swipper-wrapper" class="flex flex-row justify-around">
                                <swiper :navigation="true" :modules="[Navigation]" @slideChange="onSlideChange" :slides-per-view="3" :space-between="1" id="mySwiper">
                                    <swiper-slide v-for="image in productImages" :key=image>
                                        <figure class="w-[128px] lg:h-[128px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                            <img :src="image" class="w-[128px] lg:h-[128px] rounded-lg" />
                                        </figure>
                                    </swiper-slide>
                                </swiper>
                            </div>
                            <div v-else id="shop-product-page-images-swipper-wrapper" class="flex flex-row justify-around">
                                <figure class="w-[128px] lg:h-[128px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                    <img src="/storage/img/p/not-found.jpg" class="w-[128px] lg:h-[128px] rounded-lg" />
                                </figure>
                                <figure class="w-[128px] lg:h-[128px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                    <img src="/storage/img/p/not-found.jpg" class="w-[128px] lg:h-[128px] rounded-lg" />
                                </figure>
                                <figure class="w-[128px] lg:h-[128px] rounded-lg bg-white mb-4 flex items-center justify-center">
                                    <img src="/storage/img/p/not-found.jpg" class="w-[128px] lg:h-[128px] rounded-lg" />
                                </figure>
                            </div>
                        </div>

                        <div class="px-4">
                            <h2 class="mb-2 leading-tight tracking-tight font-bold text-gray-800 text-2xl md:text-3xl">{{ product.name }}</h2>
                            <p v-if="props.seller_name !== null" class="text-gray-500 text-sm">Solded by {{ props.seller_name }}</p>

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


                            <div class="flex py-4 space-x-4">
                                <div class="relative">
                                    <div class="text-center left-0 pt-2 right-0 absolute block text-xs uppercase text-gray-400 tracking-wide font-semibold">Qty</div>
                                    <select v-model="currentSelectedQuantity" class="cursor-pointer appearance-none rounded-xl border border-gray-200 pl-4 pr-8 h-14 flex items-end pb-1">
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

                                <button @click="addToCart(props.product, currentSelectedQuantity, retailPrice)" type="button" class="h-14 px-6 py-2 font-semibold rounded-xl bg-red-900 hover:bg-red-700 text-white">
                                    Add to Cart
                                </button>                            
                                
                            </div>
                            <Link
                                v-if="props.seller_id !== null"
                                :href="route('contactSeller', {locale: props.locale, slug: props.product.slug, seller_id: props.seller_id}, false, Ziggy)"
                                class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                            >
                                Want to contact the seller ? Click here !
                            </Link>
                            <div v-if="props.feature_size_values.length >= 1">
                                <SizeSelector :locale="props.locale" :size-values="feature_size_values" @selectSize="selectSize"></SizeSelector>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="shop-product-page-description-wrapper" class="flex flex-col justify-center mx-4 lg:mx-32 my-3">
            <div class="flex flex-row justify-center gap-12">
                <h2 @click="selectDescription" id="title-product-description" class="text-2xl font-bold cursor-pointer border-b-4 hover:border-red-800">Description</h2>
                <h2 @click="selectFeatures" id="title-product-feature" class="text-2xl font-bold cursor-pointer border-b-4 hover:border-red-800">Features</h2>
            </div>
            <div v-if="props.product.description != null && descriptionSelected == true" id="product-description" class="max-w-82 lg:max-w-full min-h-96 bg-white my-6 rounded-md">
                <p class="text-lg px-6 py-6">{{ props.product.description }}</p>
            </div>
            <div v-else-if="props.product.description == null && descriptionSelected == true" id="product-description" class="max-w-82 lg:max-w-full min-h-96 bg-white my-6 rounded-md">
                <p class="text-lg px-6 py-6">Product description is empty</p>
            </div>
            <div v-else-if="featuresSelected == true" id="product-features" class="max-w-82 lg:max-w-full min-h-96 bg-white my-6 rounded-md">
                <p class="text-lg px-6 py-6"></p>
            </div>
            <div v-else-if="props.product == null && descriptionSelected == true" id="product-description" class="max-w-82 lg:max-w-full min-h-96 bg-white my-6 rounded-md">
                <p class="text-lg px-6 py-6">Product description is empty</p>
            </div>
        </section>
    </main>
    <ShopFooter :locale="props.locale"></ShopFooter>
</template>