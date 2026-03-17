<script setup lang="ts">
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import { Category } from '@/types/category';
import { Order } from '@/types/order';

interface OrderConfirmationProps {
    order: Order
    frontCategories: Category[]
    cartProductsCount: number
    price:number
    productImages: string[]
}

const props = defineProps<OrderConfirmationProps>()
</script>

<template>
    <ShopHeader :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
    <section class="form form-col gap-4 rounded-xl bg-white p-3">
        <hgroup class="form form-col gap-2 rounded-lg bg-green-200 px-5 py-3">
            <h2 class="text-green-800">Your order <span>{{ order.reference }}</span> is confirmed</h2>
            <p class="text-green-600">An email has been sent to your mail address <span class="text-black">{{ $page.props.auth.customer.email }}</span></p>
        </hgroup>
        <p>You can find your order resume in your account page</p>
    </section>
    <ShopFooter></ShopFooter>
</template>