<script setup lang="ts">
import { useTrans } from '@/composables/trans';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { Category } from '@/types/category';
import { Order } from '@/types/order';

interface OrderConfirmationProps {
    order: Order
    frontCategories: Category[]
    cartProductsCount: number
    price:number
    productImages: string[]
    locale: string
}

const props = defineProps<OrderConfirmationProps>()
</script>

<template>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <section class="form form-col gap-4 rounded-xl bg-white p-3">
            <hgroup class="form form-col gap-2 rounded-lg bg-green-200 px-5 py-3">
                <h2 class="text-green-800">{{ useTrans('Your order') }}<span>{{ order.reference }}</span> {{ useTrans('is confirmed') }}</h2>
                <p class="text-green-600">{{ useTrans('An email has been sent to your mail address') }}<span class="text-black">{{ $page.props.auth.customer.email }}</span></p>
            </hgroup>
            <p>{{ useTrans('You can find your order resume in your account page') }}</p>
        </section>
    </AppShopLayout>
</template>