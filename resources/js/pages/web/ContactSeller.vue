<script setup lang="ts">
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import { Category } from '@/types/category';
import { Seller } from "@/types/seller";
import ContactSellerForm from "@/components/jewellery_store/form/ContactSellerForm.vue";
import { Customer } from "@/types/customer";
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '@/composables/trans';

interface ContactPageProps {
    frontCategories: Category[]
    cartProductsCount: number
    seller: Seller
    customer: null|Customer
    slug: string
    locale: string
}

const props =  defineProps<ContactPageProps>();
</script>

<template>
    <Head title="Contacter le Vendeur">
        <meta name="description" content="Envoyez un message directement au vendeur pour toute question sur un bijou, une commande ou un délai de livraison." head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <h2 class="text-3xl my-6 mx-15">{{ useTrans('Contact the seller') }}</h2>
        <ContactSellerForm classname="" :seller="props.seller" :customer="props.customer" :slug="props.slug" :locale="props.locale"></ContactSellerForm>
    </AppShopLayout>
    <ShopFooter :locale="props.locale"></ShopFooter>
</template>