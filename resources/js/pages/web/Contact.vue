<script setup lang="ts">
import ContactForm from '@/components/jewellery_store/form/ContactForm.vue';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { Category } from '@/types/category';

interface ContactPageProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props =  defineProps<ContactPageProps>();
</script>

<template>
    <Head title="Contact">
        <meta name="description" content="Contactez l'équipe JewelleryStore pour toute question sur vos commandes, bijoux ou services. Nous vous répondons dans les plus brefs délais." head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <h2 class="text-3xl my-6 mx-15">Contact</h2>
        <ContactForm classname="" :locale="props.locale"></ContactForm>
    </AppShopLayout>
</template>