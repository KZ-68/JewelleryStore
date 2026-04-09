<script setup lang="ts">
import axios from 'axios'
import type { Product } from '@/types/product'
import { inject, onMounted, Ref, ref } from "vue";
import { ShoppingCart } from 'lucide-vue-next';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../ziggy.js';
import { useTrans } from '@/composables/trans';

interface ProductCardProps {
    classname: string
    product: Product
    image: null | string
    sortBy: string
    order: 'asc' | 'desc'
    locale: string
}

const retailPrice = ref(0);
const openCartModalValue = inject<Ref<boolean>>('openCartModalValue');

const props = defineProps<ProductCardProps>()

async function addToCart(product: Product, quantity: number, retailPrice: number) {
    try {
        await axios.post(
            route('cart.addToCart', {locale: props.locale, product: product, quantity: quantity, retail_price: retailPrice}, false, Ziggy)
        )
    } catch (error) {
        console.error('Erreur:', error);
    }
    openCartModalValue.value = true;
}

onMounted(async () => {
    try {
        await axios.post(
            route('products.shopRetailPrice', {locale: props.locale, slug: props.product.slug}, false, Ziggy),
            {locale: props.locale, slug: props.product.slug}
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
    <article class="w-full bg-white flex flex-col rounded-lg overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow">

        <div class="relative w-full aspect-square bg-gray-50 overflow-hidden">
            <a
                :href="route('products.showShopProduct', {locale: props.locale, slug: props.product.slug}, false, Ziggy)"
                tabindex="-1"
                aria-hidden="true"
                class="absolute inset-0 flex items-center justify-center p-3"
            >
                <img
                    :src="props.image ?? '/storage/img/p/not-found.jpg'"
                    :alt="useTrans(props.product.name)"
                    class="w-full h-full object-contain"
                >
            </a>
        </div>

        <div class="flex items-center gap-2 px-2.5 py-2.5 sm:px-3">
            <div class="min-w-0 flex-1">
                <a
                    :href="route('products.showShopProduct', {locale: props.locale, slug: props.product.slug}, false, Ziggy)"
                    class="block text-xs sm:text-sm font-semibold text-gray-800 truncate hover:text-[#84070F] transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] rounded-sm"
                >
                    {{ useTrans(props.product.name) }}
                </a>
                <span class="text-xs sm:text-sm font-bold text-amber-700">
                    {{ retailPrice }}
                </span>
            </div>

            <button
                type="button"
                :aria-label="`Ajouter ${props.product.name} au panier`"
                @click="addToCart(props.product, 1, retailPrice); $emit('addProduct', props.product); $emit('addProductQuantity', 1); $emit('addProductPrice', props.product.retail_price);"
                class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-shop-primary text-white hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-offset-1 cursor-pointer"
            >
                <ShoppingCart class="w-3.5 h-3.5" />
            </button>
        </div>

    </article>
</template>
