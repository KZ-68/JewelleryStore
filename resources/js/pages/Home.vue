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

const openCartModalValue = ref<boolean>(false)
provide('openCartModalValue', openCartModalValue)

const productsAdded = ref<Product[]>([])
const productsQuantity = ref<number>(0)
const productsPrice = ref<number>(0)

const addProduct = (key: Product) => { productsAdded.value.push(key) }
const addProductQuantity = (key: number) => { productsQuantity.value += key }
const addProductPrice = (key: number) => { productsPrice.value += key }
</script>

<template>
    <Head title="Home">
        <meta name="description" content="JewelleryStore — Découvrez notre collection de bijoux : colliers, bagues, bracelets et plus encore. Livraison sécurisée, retours sous 30 jours." head-key="description" />
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
        <BlockCartModal
            v-model:is-open-value="openCartModalValue"
            :locale="props.locale"
            :products="productsAdded"
            :productsPrice="productsPrice"
            :productsQuantity="productsQuantity"
            :cartProductsCount="props.cartProductsCount"
            :defaultShippingRatePrice="props.defaultShippingRatePrice"
        />
    </AppShopLayout>
</template>
