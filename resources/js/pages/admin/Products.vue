<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Product } from '@/types/product'
import ProductsList from '@/components/jewellery_store/list/products/ProductsList.vue'
// import { router } from '@inertiajs/vue3'
// import { ref } from "vue";
// import { route } from '../../../../vendor/tightenco/ziggy';
// import { Ziggy } from '../../ziggy.js';

interface ProductsProps {
  products: Product[]
//   filters: {
//     sortBy: string
//     order: string
//   }
}  

const props = defineProps<ProductsProps>()
  
// const sortBy = ref<string>(props.filters.sortBy || 'name')
// const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'asc')

// const url = route('admin.back-office.showProducts', {}, false, Ziggy);

// const updateFilters = () => {
//   router.get(url, {
//     sortBy: sortBy.value,
//     order: order.value,
//   });
// }

// const navigate = (url: string) => {
//   router.visit(url, { preserveScroll: true, preserveState: true })
// }
</script>

<template>
    <Head title="Products" />
    <div id="manufacturers-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
      <h2 class="text-3xl my-6">Products</h2>
      <ProductsList
        classname=""
        :products=props.products
      />
    </div>
</template>