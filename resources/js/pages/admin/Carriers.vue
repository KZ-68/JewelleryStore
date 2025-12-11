<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link} from '@inertiajs/vue3';
import type { Carrier } from '@/types/carrier'
import CarriersList from '@/components/jewellery_store/list/carriers/CarriersList.vue'
import { newCarrier } from '@/actions/App/Http/Controllers/Admin/CarrierFrontController';
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';

interface CarriersProps {
  carriers: Carrier[]
  filters: {
    sortBy: string
    order: string
  }
}  

const props = defineProps<CarriersProps>()
  
const sortBy = ref<string>(props.filters.sortBy || 'name')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'asc')

const url = route('admin.back-office.showCarriers', {}, false, Ziggy);

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
    <Head title="Carriers" />
    <AppLayout>
      <div id="carriers-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Carriers</h2>
        <section id="carriers-top-wrapper" class="flex flex-row justify-between items-center">
          <div id="carriers-filters-wrapper" class="flex flex-row my-6 gap-2">
            <label for="sortBy" class="my-4">Trier par :</label>
            <select id="sortBy" v-model="sortBy" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
              <option value="name">Nom</option>
              <option value="created_at">Date de création</option>
            </select>
            <select id="order" v-model="order" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
              <option value="asc">Ascendant</option>
              <option value="desc">Descendant</option>
            </select>
          </div>
          <nav id="carriers-top-nav" class="flex flex-row">
            <Link
                :href="newCarrier()"
                class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Add a new carrier
            </Link>
          </nav>
        </section>
        
        <CarriersList
          classname=""
          :carriers=props.carriers
          :sort-by="sortBy"
          :order="order"
        />
      </div>
    </AppLayout>
</template>