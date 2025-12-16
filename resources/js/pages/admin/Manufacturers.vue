<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link} from '@inertiajs/vue3';
import type { Manufacturer } from '@/types/manufacturer'
import ManufacturersList from '@/components/jewellery_store/list/manufacturers/ManufacturersList.vue'
import { newManufacturer } from '@/actions/App/Http/Controllers/Admin/ManufacturerFrontController';
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';
import Button from '@/components/ui/button/Button.vue';

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

const deleteBulkRef = ref(null)

const deleteSelected = () => {
    const names = deleteBulkRef.value.getSelected();
    if (!names.length) return

    if (confirm("Supprimer les éléments sélectionnés ?")) {
        router.post(route('delete-manufacturers', {}, false, Ziggy), { names })
    }
}

const navigate = (url: string) => {
  router.visit(url, { preserveScroll: true, preserveState: true })
}
</script>

<template>
    <Head title="Manufacturers" />
    <AppLayout>
      <div id="manufacturers-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Manufacturers</h2>
        <section id="manufacturers-top-wrapper" class="flex flex-col-reverse xl:flex-row justify-between items-center">
          <div id="manufacturers-filters-wrapper" class="flex flex-row my-6 gap-2">
            <label for="sortBy" class="my-4">Order by :</label>
            <select id="sortBy" v-model="sortBy" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
              <option value="name">Name</option>
              <option value="created_at">Date created</option>
            </select>
            <select id="order" v-model="order" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
              <option value="asc">Ascendant</option>
              <option value="desc">Descendant</option>
            </select>
          </div>
          <nav id="manufacturers-top-nav" class="flex flex-row gap-3">
            <Button
                class="bg-black text-white"
                :tabindex="1"
                @click="deleteSelected()"
                >
                  Delete selected manufacturer
            </Button>
            <Link
                :href="newManufacturer()"
                class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Add a manufacturer
            </Link>
          </nav>
        </section>
        
        <ManufacturersList
          classname=""
          :manufacturers=props.manufacturers
          :sort-by="sortBy"
          :order="order"
          ref="deleteBulkRef"
        />
      </div>
    </AppLayout>
</template>