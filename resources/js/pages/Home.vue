<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Category } from '@/types/category';
import { Product } from '@/types/product';
import TopProductCarousel from '@/components/jewellery_store/carousel/TopProductCarousel.vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';

interface HomeProps {
    frontCategories: Category[]
    topProducts: Product[]
    cartProductsCount: number
}

const props = defineProps<HomeProps>()
</script>

<template>
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]"
    >
        <ShopHeader :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
        <main
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <TopProductCarousel :topProducts="props.topProducts"></TopProductCarousel>
        </main>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
