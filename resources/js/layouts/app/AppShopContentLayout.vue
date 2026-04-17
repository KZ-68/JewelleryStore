<script setup lang="ts">
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import ShopContent from '@/components/jewellery_store/ShopContent.vue';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import ShopHomeContent from '@/components/jewellery_store/ShopHomeContent.vue';
import type { BreadcrumbItemType } from '@/types';
import type { Category } from '@/types/category';
import { useCookieConsent } from '@/composables/useCookieConsent';
import { useWindowSize } from '@vueuse/core';
import { onMounted, provide, ref } from 'vue';

interface Props {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
    isHome: boolean
    breadcrumbs?: BreadcrumbItemType[]
}

const props = defineProps<Props>()

const { width } = useWindowSize()
const active = ref<boolean>(false)
provide('active', active)
const openNav = () => {
  active.value = true
}

const { init: initCookieConsent } = useCookieConsent()
onMounted(() => initCookieConsent())
</script>

<template>
    <button v-if="width <= 430" id="openBtn" @click="openNav" class="absolute top-0 left-0 flex flex-col gap-1 p-4 bg-white z-[2]">
        <div class="w-[20px] h-0.5 bg-shop-primary"></div>
        <div class="w-[20px] h-0.5 bg-shop-primary"></div>
        <div class="w-[20px] h-0.5 bg-shop-primary"></div>
    </button>
    <ShopHeader v-if="width > 430" :locale="props.locale" :front-categories="props.frontCategories" :cart-products-count="props.cartProductsCount"></ShopHeader>
    <BurgerMenu v-else :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :active="active" :locale="props.locale"></BurgerMenu>
    <ShopContent v-if="isHome === false" :breadcrumbs="props.breadcrumbs">
        <slot />
    </ShopContent>
    <ShopHomeContent v-else-if="isHome === true">
        <slot />
    </ShopHomeContent>
    <ShopFooter :locale="props.locale"></ShopFooter>
</template>