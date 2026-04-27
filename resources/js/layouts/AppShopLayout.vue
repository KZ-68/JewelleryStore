<script setup lang="ts">
import AppShopLayout from '@/layouts/app/AppShopContentLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import type { Category } from '@/types/category';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    locale: string;
    frontCategories: Category[]
    cartProductsCount: number
    isHome: boolean
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShopLayout :isHome="props.isHome" :locale="locale" :front-categories="props.frontCategories" :cart-products-count="props.cartProductsCount" :breadcrumbs="breadcrumbs">
        <slot />
    </AppShopLayout>
</template>