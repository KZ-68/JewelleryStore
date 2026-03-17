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


interface HomeProps {
    frontCategories: Category[]
    topProducts: Product[]
    cartProductsCount: number
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
    <div class="relative flex min-h-screen flex-col bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]">
        <button v-if="width <= 430" id="openBtn" @click="openNav" class="absolute top-0 left-0 flex flex-col gap-1 p-4 bg-white z-[2]">
            <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
            <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
            <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
        </button>
        <ShopHeader v-if="width > 430" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
        <BurgerMenu v-else :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :active="active"></BurgerMenu>
        <main
            class="flex flex-col w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <Slider></Slider>
            <TopProductCarousel :topProducts="props.topProducts"></TopProductCarousel>
            <DiscoverCategorySection :categories="frontCategories" category_name="Noir" description="Catchphrase placeholder for appealing customer to this category" :isCollection="true"></DiscoverCategorySection>
            <SellerRegistrationInvitationBanner></SellerRegistrationInvitationBanner>
        </main>
        <div class="hidden h-14.5 lg:block"></div>
        <ShopFooter></ShopFooter>
    </div>
</template>
