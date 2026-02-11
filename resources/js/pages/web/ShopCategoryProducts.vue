<script setup lang="ts">
import type { Product } from '@/types/product'
import ProductCard from '@/components/jewellery_store/card/ProductCard.vue';
import CategoryMenu from '@/components/jewellery_store/nav/CategoryMenu.vue';
import { Category } from '@/types/category';
import { Head, router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';

interface ProductsListProps {
    classname:string
    category_slug: string
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

const url = route('showCategoryProducts', {slug: props.category_slug}, false, Ziggy);

const updateCustomersFilters = () => {
  router.get(url, {
    sortBy: sortBy.value,
    order: order.value,
  });
}
</script>

<template>
    <ShopHeader :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
    <main class="flex flex-col h-fit gap-8 px-24 py-8 bg-gray-100">
        <h1 class="my-4 text-3xl">Products Category</h1>
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
                <div class="flex flex-wrap">
                    <ProductCard v-for="product in props.products" classname="" :product="product" :image="null" :key="product.id"></ProductCard>
                </div>
            </div>
        </div>
    </main>
</template>