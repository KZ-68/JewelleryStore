<script setup lang="ts">
import type { Product } from '@/types/product'
import ProductCard from '@/components/jewellery_store/card/ProductCard.vue';
import { Category } from '@/types/category';
import { router } from '@inertiajs/vue3'
import { provide, ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import { useWindowSize } from '@vueuse/core';

interface ProductsListProps {
    classname:string
    category_slug: string
    category_name: string
    products: Product[]
    frontCategories: Category[]
    filters: {
        sortBy: string
        order: string
    }
    cartProductsCount: number
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<ProductsListProps>()

const sortBy = ref<string>(props.filters.sortBy || 'name')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'desc')

const url = route('showCategoryProducts', {category_slug: props.category_slug}, false, Ziggy);

const updateCustomersFilters = () => {
  router.get(url, {
    sortBy: sortBy.value,
    order: order.value,
  });
}

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
    <main class="flex flex-col h-fit gap-8 px-24 py-8 bg-gray-100">
        <h1 class="my-4 text-3xl">Products for {{ category_name }} Category</h1>
        <div id="products-category-body" class="flex flex-row gap-48">
            <section class="flex flex-col flex-wrap gap-3 px-3 py-2 rounded-xl bg-white">
                <div id="category-products-filters-wrapper" class="flex flex-col my-6 gap-4">
                <label for="sortBy" class="my-4">Sorting products by :</label>
                <select id="sortBy" v-model="sortBy" @change="updateCustomersFilters" class="rounded-md bg-neutral-100 px-2">
                    <option value="name">Name</option>
                    <option value="created_at">Date</option>
                </select>

                <label for="price" class="my-4">Sorting products price by :</label>
                <select id="sortBy" v-model="sortBy" @change="updateCustomersFilters" class="rounded-md bg-neutral-100 px-2">
                    <option value="price_ht">Price without tax</option>
                    <option value="retail_price">Retail price</option>
                </select>

                <label for="order">Order products by</label>
                <select id="order" v-model="order" @change="updateCustomersFilters" class="rounded-md bg-neutral-100 px-2">
                    <option value="asc">Ascendant</option>
                    <option value="desc">Descendant</option>
                </select>
                </div>
            </section>
            <div class="flex flex-col w-full h-auto mt-[3%]">
                <div class="flex flex-wrap gap-10">
                    <ProductCard v-for="product in props.products" classname="" :product="product" :image="null" :key="product.id" :sort-by="sortBy" :order="order"></ProductCard>
                </div>
            </div>
        </div>
    </main>
</template>