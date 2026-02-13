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
        <div class="flex flex-row gap-3 px-4 py-3 bg-white border-gray-100 border-b-2">
            <p>{{ product.name }}</p>
            <b>{{ retailPrice}}</b>
        </div>
    </Link>

</template>