<script setup lang="ts">
import CartBody from './body/CartBody.vue';
import CartHeader from './header/CartHeader.vue';

</script>

<template>
    <section
        class="max-w-[900px] flex-start mt-20 ml-15 py-10 px-12 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800"
    >
    <CartHeader classname="" title="Panier"/>
    <CartBody classname="flex flex-row" name="test" :quantity=0 price="2,50" />
    </section>
</template>