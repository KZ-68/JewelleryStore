<script setup lang="ts">
import CartBody from './body/CartBody.vue';
import CartHeader from './header/CartHeader.vue';

interface CartProduct {
    product_id: number
    name: string
    quantity: number
    price: number
}

interface CartLeftColumnProps {
    products: Array<CartProduct>
}

const props = defineProps<CartLeftColumnProps>();
</script>

<template>
    <section
        class="lg:w-[900px] max-w-[900px] flex-start my-10 px-8 pt-20 pb-10 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800"
    >
    <CartHeader classname="" title="Panier" :products="props.products"/>
    <CartBody classname="flex flex-row" :products="props.products"/>
    </section>
</template>