<script setup lang="ts">
import { provide, ref } from "vue";
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import { useWindowSize } from '@vueuse/core';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import { Category } from '@/types/category';
import { Seller } from "@/types/seller";
import ContactSellerForm from "@/components/jewellery_store/form/ContactSellerForm.vue";
import { Customer } from "@/types/customer";

interface ContactPageProps {
    frontCategories: Category[]
    cartProductsCount: number
    seller: Seller
    customer: null|Customer
    slug: string
}

const props =  defineProps<ContactPageProps>();
const { width } = useWindowSize()
const active = ref<boolean>(false)
provide('active', active)
const openNav = () => {
  active.value = true
}
</script>

<template>
    <button v-if="width <= 430" id="openBtn" @click="openNav" class="absolute top-0 left-0 flex flex-col gap-1 p-4 bg-white z-[2]">
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
        <div class="w-[20px] h-0.5 bg-[#84070F]"></div>
    </button>
    <ShopHeader v-if="width > 430" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount"></ShopHeader>
    <BurgerMenu v-else :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :active="active"></BurgerMenu>
    <main class="items-center min-h-screen p-6 text-[#1b1b18] lg:justify-center lg:p-8 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6 mx-15">Contact the seller</h2>
        <ContactSellerForm classname="" :seller="props.seller" :customer="props.customer" :slug="props.slug"></ContactSellerForm>
    </main>
    <ShopFooter></ShopFooter>
</template>