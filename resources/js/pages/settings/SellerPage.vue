<script setup lang="ts">
import type { Product } from '@/types/product'
import { Category } from '@/types/category';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import { useWindowSize } from '@vueuse/core';
import { provide, ref } from 'vue';
import ProductsList from '@/components/jewellery_store/list/products/ProductsList.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

interface SellerPage {
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

const props = defineProps<SellerPage>()
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
        <SettingsLayout>
            <div class="w-[80rem] mx-auto my-auto">
                <nav>
                    <ul class="flex flex-row gap-0">
                        <li class="py-2 px-3">Products</li>
                    </ul>
                </nav>
                <div class="flex flex-col w-full h-auto mt-[3%]">
                    <ProductsList classname="" :products="props.products" :sort-by="sortBy" :order="props.order"></ProductsList>
                </div>
            </div>
        </SettingsLayout>
        
    </main>
    <ShopFooter></ShopFooter>
</template>