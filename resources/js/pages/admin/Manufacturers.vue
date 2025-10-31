<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Manufacturer } from '@/types/manufacturer'
import ManufacturersList from '@/components/jewellery_store/list/manufacturers/ManufacturersList.vue'
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';

interface ManufacturersProps {
  manufacturers: Manufacturer[]
  filters: {
    sortBy: string
    order: string
  }
}  

const props = defineProps<ManufacturersProps>()
  
const sortBy = ref<string>(props.filters.sortBy || 'name')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'asc')

const url = route('admin.back-office.showManufacturers', {}, false, Ziggy);

const updateFilters = () => {
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
    <Head title="Manufacturers" />
    <div id="manufacturers-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
      <h2 class="text-3xl my-6">Manufacturers</h2>
      <label for="sortBy" class="my-4">Trier par :</label>
      <div id="manufacturers-filters-wrapper" class="flex flex-row my-6 gap-2">
        <select id="sortBy" v-model="sortBy" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
          <option value="name">Nom</option>
          <option value="created_at">Date de création</option>
        </select>
        <select id="order" v-model="order" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
          <option value="asc">Ascendant</option>
          <option value="desc">Descendant</option>
        </select>
      </div>
      <ManufacturersList
        classname=""
        :manufacturers=props.manufacturers
        :sort-by="sortBy"
        :order="order"
      />
    </div>
</template>