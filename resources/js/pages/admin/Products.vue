<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Product } from '@/types/product'
import ProductsList from '@/components/jewellery_store/list/products/ProductsList.vue'
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';
import { newProduct } from '@/actions/App/Http/Controllers/Admin/ProductFrontController';

interface ProductsProps {
  products: Product[]
  filters: {
    sortBy: string
    order: string
  }
}  

const props = defineProps<ProductsProps>()
  
const sortBy = ref<string>(props.filters.sortBy || 'id')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'desc')

const url = route('admin.back-office.showProducts', {}, false, Ziggy);

const updateProductsFilters = () => {
  router.get(url, {
    sortBy: sortBy.value,
    order: order.value,
  });
}

const navigate = (url: string) => {
  router.visit(url, { preserveScroll: true, preserveState: true })
}
</script>

<template>
    <Head title="Products" />
    <AppLayout>
      <div id="products-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Products</h2>
        <section id="products-top-wrapper" class="flex lg:flex-row sm:flex-col lg:my-0 sm:my-6 justify-between items-center">
            <div id="products-filters-wrapper" class="flex flex-row my-6 gap-4">
              <label for="sortBy" class="my-4">Order by :</label>
              <select id="sortBy" v-model="sortBy" @change="updateProductsFilters" class="rounded-md bg-neutral-100 px-2">
                <option value="id">Id</option>
                <option value="name">Name</option>
                <option value="created_at">Date created</option>
              </select>
              <select id="order" v-model="order" @change="updateProductsFilters" class="rounded-md bg-neutral-100 px-2">
                <option value="asc">Ascendant</option>
                <option value="desc">Descendant</option>
              </select>
            </div>
            <nav id="products-top-nav" class="flex flex-row">
              <Link
                  :href="newProduct()"
                  class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
              >
                  Add a product
              </Link>
            </nav>
        </section>

        <ProductsList
          classname=""
          :products=props.products
          :sort-by="sortBy"
          :order="order"
        />
      </div>
    </AppLayout>
</template>