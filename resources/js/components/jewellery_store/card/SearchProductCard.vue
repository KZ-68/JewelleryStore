<script setup lang="ts">
import axios from 'axios'
import { Link } from '@inertiajs/vue3';
import type { Product } from '@/types/product'
import { onMounted, ref } from "vue";
import { ShoppingCart } from 'lucide-vue-next';
import { showShopProduct } from '@/routes/products'
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../ziggy.js';

interface SearchProductCardProps {
    product: Product
    image: null|string
}

const retailPrice = ref(0);

const props = defineProps<SearchProductCardProps>()

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
    <Link :href="showShopProduct({slug: product.slug})">
        <div class="flex flex-row gap-3 items-center px-4 py-3 bg-white border-gray-100 border-b-2">
            <figure class="flex justify-center py-2 items-center min-w-20 max-w-20 lg:w-full">
                <img :src="props.image ? props.image : '/storage/img/p/not-found.jpg'" alt="Jewellery Product Image" class="min-w-20 max-w-20">
            </figure>
            <p>{{ product.name }}</p>
            <b>{{ retailPrice}}</b>
        </div>
    </Link>

</template>