<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import axios from 'axios'
import type { Product } from '@/types/product'
import { Category } from '@/types/category';
import { Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { ref, computed } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import SizeSelector from '@/components/jewellery_store/select/SizeSelector.vue';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '../../composables/trans';

interface ProductsListProps {
    classname: string
    product: Product
    frontCategories: Category[]
    cartProductsCount: number
    price: number
    productImages: string[]
    seller_id: null | number
    seller_name: null | string
    locale: string
    feature_size_values: Array<string>
}

const props = defineProps<ProductsListProps>()

const retailPrice = ref(0);
const currentSelectedSize = ref<string>('');
const currentSelectedQuantity = ref<number>(1);

async function addToCart(product: Product, quantity: number, retailPrice: number) {
    if (currentSelectedSize.value !== '') {
        try {
            await axios.post(
                route('cart.addToCart', {locale: props.locale, product: product, quantity: quantity, retail_price: retailPrice, selected_size: currentSelectedSize.value}, false, Ziggy)
            )
        } catch (error) {
            console.error('Erreur:', error);
        }
    }
}

const activeIndex = ref(0)

const mainImage = computed(() =>
    props.productImages.length > 0
        ? props.productImages[activeIndex.value]
        : '/storage/img/p/not-found.jpg'
)

function onSlideChange(swiper: any) {
    activeIndex.value = swiper.activeIndex
}

function selectThumbnail(index: number) {
    activeIndex.value = index
}

const thumbnailBreakpoints = {
    0:   { slidesPerView: 3, spaceBetween: 8 },
    768: { slidesPerView: 4, spaceBetween: 10 },
}

const activeTab = ref<'description' | 'features'>('description')

const selectSize = (key: string) => {
    currentSelectedSize.value = key
}
</script>

<template>
    <AppShopLayout
        :isHome="false"
        :frontCategories="props.frontCategories"
        :cartProductsCount="props.cartProductsCount"
        :locale="props.locale"
    >
        <div class="bg-gray-100 min-h-screen">
            <div class="max-w-screen-xl mx-auto px-4 md:px-8 lg:px-12 py-8">

                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">{{ props.product.name }}</h1>
                    <p v-if="props.seller_name !== null" class="mt-1 text-sm text-gray-500">
                        {{ useTrans('Sold by') }} <span class="font-medium">{{ props.seller_name }}</span>
                    </p>
                </div>

                <section aria-label="Product details" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-8">
                    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

                        <div class="w-full lg:w-[420px] shrink-0 flex flex-col gap-3">

                            <figure class="w-full aspect-square rounded-xl bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                                <img
                                    :src="mainImage"
                                    :alt="props.product.name"
                                    class="w-full h-full object-contain p-4 transition-opacity duration-200"
                                >
                            </figure>

                            <div v-if="props.productImages.length > 1" class="w-full">
                                <swiper
                                    :modules="[Navigation]"
                                    :navigation="true"
                                    :breakpoints="thumbnailBreakpoints"
                                    @slideChange="onSlideChange"
                                    aria-label="Thumbnail product"
                                >
                                    <swiper-slide
                                        v-for="(image, index) in props.productImages"
                                        :key="image"
                                    >
                                        <button
                                            @click="selectThumbnail(index)"
                                            :aria-label="`Voir l'image ${index + 1}`"
                                            class="w-full focus:outline-none focus:ring-2 focus:ring-[#84070F] rounded-lg"
                                            :class="activeIndex === index ? 'ring-2 ring-[#84070F]' : ''"
                                        >
                                            <figure class="w-full aspect-square rounded-lg bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center p-1">
                                                <img
                                                    :src="image"
                                                    :alt="`${props.product.name} – vue ${index + 1}`"
                                                    class="w-full h-full object-contain"
                                                >
                                            </figure>
                                        </button>
                                    </swiper-slide>
                                </swiper>
                            </div>

                            <div v-else class="grid grid-cols-3 gap-2">
                                <figure
                                    v-for="n in 3"
                                    :key="n"
                                    class="w-full aspect-square rounded-lg bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center"
                                >
                                    <img src="/storage/img/p/not-found.jpg" alt="" aria-hidden="true" class="w-full h-full object-contain p-1">
                                </figure>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col gap-6">

                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-bold text-red-900">{{ props.price }}</span>
                                <span class="text-red-800 text-lg">€</span>
                                <span class="ml-2 text-sm text-gray-400">{{ useTrans('All taxes included') }}</span>
                            </div>

                            <div v-if="props.feature_size_values.length >= 1">
                                <SizeSelector
                                    :locale="props.locale"
                                    :size-values="feature_size_values"
                                    @selectSize="selectSize"
                                />
                            </div>

                            <div class="flex flex-wrap items-center gap-4">
                                <div class="relative">
                                    <label for="product-quantity" class="absolute top-1.5 left-4 text-xs uppercase text-gray-400 tracking-wide font-semibold">
                                        {{ useTrans('Qty') }}
                                    </label>
                                    <select
                                        id="product-quantity"
                                        v-model="currentSelectedQuantity"
                                        aria-label="quantity"
                                        class="cursor-pointer appearance-none rounded-xl border border-gray-200 pl-4 pr-8 pt-6 pb-2 focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                    >
                                        <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                                    </select>
                                    <svg aria-hidden="true" class="w-4 h-4 text-gray-400 absolute right-2 bottom-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                    </svg>
                                </div>

                                <button
                                    @click="addToCart(props.product, currentSelectedQuantity, retailPrice)"
                                    type="button"
                                    :aria-label="`Add ${props.product.name} to cart`"
                                    class="flex-1 sm:flex-none h-14 px-8 py-2 font-semibold rounded-xl bg-shop-primary hover:bg-red-900 text-white transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-offset-2"
                                >
                                    {{ useTrans('Add to cart') }}
                                </button>
                            </div>

                            <Link
                                v-if="props.seller_id !== null"
                                :href="route('contactSeller', {locale: props.locale, slug: props.product.slug, seller_id: props.seller_id}, false, Ziggy)"
                                class="inline-flex items-center justify-center rounded-xl border border-gray-800 px-5 py-3 text-sm font-medium text-gray-800 hover:bg-gray-800 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-gray-800 w-fit"
                            >
                                {{ useTrans('Contact the seller') }}
                            </Link>

                            <div class="border-t border-gray-100 pt-5 mt-2">
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3" role="list" aria-label="Garanties">
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <svg aria-hidden="true" class="w-5 h-5 text-[#84070F] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ useTrans('Secured Delivery') }}</p>
                                            <p class="text-xs text-gray-400">{{ useTrans('Tracked and protected package')}}</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <svg aria-hidden="true" class="w-5 h-5 text-[#84070F] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ useTrans('Secured Payment')}}</p>
                                            <p class="text-xs text-gray-400">{{useTrans('100% secure transactions')}}</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <svg aria-hidden="true" class="w-5 h-5 text-[#84070F] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{useTrans('Returns within 30 days')}}</p>
                                            <p class="text-xs text-gray-400">{{useTrans('Money-back guarantee')}}</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <svg aria-hidden="true" class="w-5 h-5 text-[#84070F] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{useTrans('Customer service')}}</p>
                                            <p class="text-xs text-gray-400">{{useTrans('Available 7 days a week')}}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </section>

                <section aria-label="Informations produit" class="mt-8">

                    <div role="tablist" aria-label="Product section" class="flex gap-1 border-b border-gray-200">
                        <button
                            id="tab-description"
                            role="tab"
                            :aria-selected="(activeTab === 'description').toString()"
                            aria-controls="panel-description"
                            @click="activeTab = 'description'"
                            :class="activeTab === 'description'
                                ? 'border-b-2 border-[#84070F] text-[#84070F]'
                                : 'text-gray-500 hover:text-gray-700'"
                            class="px-5 py-3 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-inset"
                        >
                            {{ useTrans('Description') }}
                        </button>
                        <button
                            id="tab-features"
                            role="tab"
                            :aria-selected="(activeTab === 'features').toString()"
                            aria-controls="panel-features"
                            @click="activeTab = 'features'"
                            :class="activeTab === 'features'
                                ? 'border-b-2 border-[#84070F] text-[#84070F]'
                                : 'text-gray-500 hover:text-gray-700'"
                            class="px-5 py-3 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-inset"
                        >
                            {{ useTrans('Features') }}
                        </button>
                    </div>

                    <div
                        id="panel-description"
                        role="tabpanel"
                        aria-labelledby="tab-description"
                        v-show="activeTab === 'description'"
                        class="bg-white rounded-b-xl rounded-tr-xl border border-t-0 border-gray-100 min-h-48 p-6 lg:p-8"
                    >
                        <p class="text-gray-700 leading-relaxed">
                            {{ props.product.description ?? useTrans('No description available for this product.') }}
                        </p>
                    </div>

                    <div
                        id="panel-features"
                        role="tabpanel"
                        aria-labelledby="tab-features"
                        v-show="activeTab === 'features'"
                        class="bg-white rounded-b-xl rounded-tr-xl border border-t-0 border-gray-100 min-h-48 p-6 lg:p-8"
                    >
                        <p class="text-gray-500 text-sm">{{ useTrans('No features listed.') }}</p>
                    </div>

                </section>
            </div>
        </div>
    </AppShopLayout>
</template>
