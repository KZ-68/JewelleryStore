<script setup lang="ts">
import ContactForm from '@/components/jewellery_store/form/ContactForm.vue';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import { Category } from '@/types/category';

interface ContactPageProps {
    frontCategories: Category[]
    cartProductsCount: number
}

const props =  defineProps<ContactPageProps>();
</script>

<template>
    <ShopHeader :front-categories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
    <main class="items-center min-h-screen p-6 text-[#1b1b18] lg:justify-center lg:p-8 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6 mx-15">Contact</h2>
        <ContactForm classname=""></ContactForm>
    </main>
    <ShopFooter></ShopFooter>
</template>