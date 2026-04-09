<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Category } from '@/types/category';
import { Product } from '@/types/product';
import TopProductCarousel from '@/components/jewellery_store/carousel/TopProductCarousel.vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import Slider from '@/components/jewellery_store/Slider.vue';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import DiscoverCategorySection from '@/components/jewellery_store/section/DiscoverCategorySection.vue';
import { useWindowSize } from '@vueuse/core'
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import { ref, provide, watch } from 'vue'
import SellerRegistrationInvitationBanner from '@/components/jewellery_store/section/SellerRegistrationInvitationBanner.vue';
import TopCategoryCarousel from '@/components/jewellery_store/carousel/TopCategoryCarousel.vue';
import AppShopLayout from '@/layouts/AppShopLayout.vue';

interface HomeProps {
    frontCategories: Category[]
    topProducts: Product[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<HomeProps>()
const { width } = useWindowSize()

const active = ref<boolean>(false)
provide('active', active)

const openNav = () => {
  active.value = true
}
</script>

<template>
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <AppShopLayout :isHome="true" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <div
            class="flex flex-col w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <Slider></Slider>
            <TopProductCarousel :topProducts="props.topProducts" :locale="props.locale"></TopProductCarousel>
            <DiscoverCategorySection :categories="frontCategories" category_name="Noir" description="Catchphrase placeholder for appealing customer to this category" :isCollection="true" :locale="props.locale"></DiscoverCategorySection>
            <hr class="text-2xl my-3 mx-4" />
            <TopCategoryCarousel></TopCategoryCarousel>
            <SellerRegistrationInvitationBanner :locale="props.locale"></SellerRegistrationInvitationBanner>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </AppShopLayout>
</template>
