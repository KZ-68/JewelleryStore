<script setup lang="ts">
import { Category } from '@/types/category';
import CartLeftColumn from '../../components/jewellery_store/cart/left_column/CartLeftColumn.vue';
import CartSummary from '@/components/jewellery_store/CartSummary.vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';

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
    defaultShippingRatePrice: number
    locale: string
}

const props = defineProps<CartProps>();
</script>

<template>
    <Head title="Mon Panier">
        <meta name="description" content="Consultez votre panier et finalisez votre commande. Livraison sécurisée et retours sous 30 jours." head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <div id="cart-wrapper">
            <div class="flex flex-row lg:justify-center gap-40">
                <CartLeftColumn :locale="props.locale" :products="props.products"/>
                <CartSummary :products="props.products" :sub_total_price="props.total_price" :defaultShippingRatePrice :locale="props.locale"></CartSummary>
            </div>
        </div>
    </AppShopLayout>
</template>