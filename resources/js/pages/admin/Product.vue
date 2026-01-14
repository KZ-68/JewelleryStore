<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Product } from '@/types/product'
import { router } from '@inertiajs/vue3'
import { ref } from "vue";

interface ProductProps {
  product: Product
}  
const props = defineProps<ProductProps>();
</script>

<template>
    <Head title="Product Details" />
    <section id="product-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <div id="product-page-header-wrapper" class="px-8 py-10">
            <figure>
                <figcaption>An product image</figcaption>
            </figure>
            <h2 id="product-heading">{{ product.name }}</h2>
        </div>
        <div id="product-page-informations-wrapper">
            
        </div>
        <div id="product-page-footer-wrapper" class="px-6 py-8">
            <nav id="product-nav-links" class="flex flex-row gap-4">
                <a href="#">Back to products list</a>            
                <a href="#">Show product on store</a>
            </nav>
        </div>
    </section>
</template>