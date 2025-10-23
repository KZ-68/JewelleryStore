<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Manufacturer } from '@/types/manufacturer'
import ManufacturersList from '@/components/jewellery_store/list/manufacturers/ManufacturersList.vue'
import { router } from '@inertiajs/vue3'
import { ref } from "vue";

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

const updateSort = () => {
  router.get(route('admin.back-office.showManufacturers'), {
    sortBy: sortBy.value,
    order: order.value,
  }, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
  })
}

const navigate = (url: string) => {
  router.visit(url, { preserveScroll: true, preserveState: true })
}
</script>

<template>
    <Head title="Manufacturers" />
    <div id="manufacturers-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
      <label for="sortBy">Trier par :</label>
      <select id="sortBy" v-model="sortBy" @change="updateSort">
        <option value="name">Nom</option>
        <option value="country">Pays</option>
        <option value="created_at">Date de création</option>
      </select>
      <ManufacturersList
        classname=""
        :manufacturers=props.manufacturers
        :sort-by="sortBy"
        :order="order"
        @navigate="navigate"
      />
    </div>
</template>