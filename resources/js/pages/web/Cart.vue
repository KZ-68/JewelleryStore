<script setup lang="ts">
import { Category } from '@/types/category';
import CartLeftColumn from '../../components/jewellery_store/cart/left_column/CartLeftColumn.vue';
import CartSummary from '@/components/jewellery_store/CartSummary.vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';

interface CartProduct {
    product_id: number
    name: string
    quantity: number
    price: number
}

interface CartProps {
    frontCategories: Category[]
    products: Array<CartProduct>
    total_price: number
    cartProductsCount: number
}

const props = defineProps<CartProps>();
</script>

<template>
    <ShopHeader :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
    <main>
        <div id="cart-wrapper" class="min-h-screen p-6 text-[#1b1b18] lg:p-8 bg-gray-100 dark:bg-[#0a0a0a]">
            <div class="flex flex-row lg:justify-center gap-40">
                <CartLeftColumn :products="props.products"/>
                <CartSummary :products="props.products" :total_price="props.total_price"></CartSummary>
            </div>
        </div>
    </main>
    <ShopFooter></ShopFooter>
</template>