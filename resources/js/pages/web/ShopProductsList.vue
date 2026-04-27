<script setup lang="ts">
import type { Product } from '@/types/product'
import ProductCard from '@/components/jewellery_store/card/ProductCard.vue';
import { Category } from '@/types/category';
import { useWindowSize } from '@vueuse/core';
import { provide, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';

interface ProductsListProps {
    classname:string
    products: Product[]
    frontCategories: Category[]
    cartProductsCount: number
    sortBy: string
    order: 'asc' | 'desc'
    locale: string
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<ProductsListProps>()
const { width } = useWindowSize()
const active = ref<boolean>(false)
provide('active', active)

const openNav = () => {
  active.value = true
}
</script>

<template>
    <Head title="Nos Bijoux">
        <meta name="description" content="Parcourez toute notre collection de bijoux : colliers, bagues, bracelets, pendentifs. Filtrez par taille, matière et prix pour trouver le bijou parfait." head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <div class="w-[1190px] mx-auto my-auto">
            <div class="flex flex-col w-full h-auto mt-[3%]">
                <div class="flex flex-wrap">
                    <ProductCard v-for="product in props.products" classname="" :product="product" :image="product.image" :key="product.id" :sort-by="sortBy" :order="order" :locale="props.locale"></ProductCard>
                </div>
            </div>
        </div>
    </AppShopLayout>
</template>