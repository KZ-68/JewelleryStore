<script setup lang="ts">
import type { Product } from '@/types/product'
import ProductCard from '@/components/jewellery_store/card/ProductCard.vue';
import CategoryMenu from '@/components/jewellery_store/nav/CategoryMenu.vue';
import { Category } from '@/types/category';

interface ProductsListProps {
    classname:string
    products: Product[]
    categories: Category[]
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<ProductsListProps>()
</script>

<template>
    <header>
        <CategoryMenu :categories="props.categories"></CategoryMenu>
    </header>
    <div class="w-[1190px] mx-auto my-auto">
        <div class="flex flex-col w-full h-auto mt-[3%]">
            <div class="flex flex-wrap">
                <ProductCard v-for="product in props.products" classname="" :product="product" :image="null" :key="product.id"></ProductCard>
            </div>
        </div>
    </div>
</template>