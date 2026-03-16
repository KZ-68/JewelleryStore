<script setup lang="ts">
import type { Product } from '@/types/product'
import { Category } from '@/types/category';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import { useWindowSize } from '@vueuse/core';
import { provide, ref } from 'vue';
import ProductsList from '@/components/jewellery_store/list/products/ProductsList.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import { Ziggy } from '@/ziggy';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';

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

const sellerProductsSelected = ref(false);
function selectSellerProducts() {
    sellerProductsSelected.value = true;
}

function deselectSellerProducts() {
    sellerProductsSelected.value = false;
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
            <div id="seller-page-wrapper" class="my-14 mx-24">
                <nav class="flex flex-row flex-wrap gap-6 w-3xl">
                    <button v-if="sellerProductsSelected === false" @click="selectSellerProducts" class="py-20 px-24 border-4 border-[#84070F] rounded-2xl text-2xl cursor-pointer hover:bg-amber-100 font-bold">All Products</button>
                    <a :href="route('seller.messagesBox', {}, false, Ziggy)" class="py-20 px-24 border-4 border-[#84070F] rounded-2xl text-2xl cursor-pointer hover:bg-amber-100 font-bold">Messages Box</a>
                </nav>
                <section v-if="sellerProductsSelected === true" class="w-[80rem] mx-auto my-10">
                    <nav>
                        <ul class="flex flex-row gap-0">
                            <li class="py-2 px-3">Products</li>
                        </ul>
                    </nav>
                    <div class="flex flex-col w-full h-auto mt-[3%]">
                        <ProductsList classname="" :products="props.products" :sort-by="sortBy" :order="props.order"></ProductsList>
                    </div>
                </section>
                <button v-if="sellerProductsSelected === true" @click="deselectSellerProducts()" class="py-2 px-6 text-white bg-[#84070F] rounded-md cursor-pointer hover:bg-red-800">Back</button>
            </div>
        </SettingsLayout>
    </main>
    <ShopFooter></ShopFooter>
</template>