<script setup lang="ts">
import { Category } from '@/types/category';
import CartLeftColumn from '../../components/jewellery_store/cart/left_column/CartLeftColumn.vue';
import CartSummary from '@/components/jewellery_store/CartSummary.vue';

interface CartProduct {
    name: string
    quantity: number
    price: number
}

interface CartProps {
    frontCategories: Category[]
    products: Array<CartProduct>
}

const props = defineProps<CartProps>();
</script>

<template>
    <header>
        <CategoryMenu :frontCategories="props.frontCategories"></CategoryMenu>
    </header>
    <div id="cart-wrapper" class="min-h-screen p-6 text-[#1b1b18] lg:p-8 bg-gray-100 dark:bg-[#0a0a0a]">
        <div class="flex flex-row lg:justify-center gap-40">
            <CartLeftColumn :products="props.products"/>
            <CartSummary :products="props.products"></CartSummary>
        </div>
    </div>
    
</template>