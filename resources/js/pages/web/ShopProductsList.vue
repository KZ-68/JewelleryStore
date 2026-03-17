<script setup lang="ts">
import type { Product } from '@/types/product'
import ProductCard from '@/components/jewellery_store/card/ProductCard.vue';
import { Category } from '@/types/category';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import { useWindowSize } from '@vueuse/core';
import { provide, ref } from 'vue';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';

interface ProductsListProps {
    classname:string
    products: Product[]
    frontCategories: Category[]
    cartProductsCount: number
    sortBy: string
    order: 'asc' | 'desc'
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
    <button v-if="width <= 430" id="openBtn" @click="openNav" class="absolute top-0 left-0 flex flex-col gap-1 p-4 bg-white z-[2]">
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
    </button>
    <ShopHeader v-if="width > 430" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
    <BurgerMenu v-else :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :active="active"></BurgerMenu>
    <main>
        <div class="w-[1190px] mx-auto my-auto">
            <div class="flex flex-col w-full h-auto mt-[3%]">
                <div class="flex flex-wrap">
                    <ProductCard v-for="product in props.products" classname="" :product="product" :image="product.image" :key="product.id" :sort-by="sortBy" :order="order"></ProductCard>
                </div>
            </div>
        </div>
    </main>
    <ShopFooter></ShopFooter>
</template>