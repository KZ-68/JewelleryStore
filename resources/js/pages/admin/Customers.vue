<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Customer } from '@/types/customer'
import CustomersList from '@/components/jewellery_store/list/customers/CustomersList.vue'
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import { newCustomer } from '@/actions/App/Http/Controllers/Admin/CustomerFrontController';

interface CustomersProps {
  customers: Customer[]
  filters: {
    sortBy: string
    order: string
  }
}  

const props = defineProps<CustomersProps>()
  
const sortBy = ref<string>(props.filters.sortBy || 'id')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'desc')

const url = route('admin.back-office.showCustomers', {}, false, Ziggy);

const updateCustomersFilters = () => {
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
    <Head title="Customers" />
    <AppLayout>
      <div id="customers-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Customers</h2>
        <section id="customers-top-wrapper" class="flex lg:flex-row sm:flex-col lg:my-0 sm:my-6 justify-between items-center">
            <div id="customers-filters-wrapper" class="flex flex-row my-6 gap-4">
              <label for="sortBy" class="my-4">Trier par :</label>
              <select id="sortBy" v-model="sortBy" @change="updateCustomersFilters" class="rounded-md bg-neutral-100 px-2">
                <option value="id">Id</option>
                <option value="name">Nom</option>
                <option value="email">Email</option>
                <option value="created_at">Date de création</option>
              </select>
              <select id="order" v-model="order" @change="updateCustomersFilters" class="rounded-md bg-neutral-100 px-2">
                <option value="asc">Ascendant</option>
                <option value="desc">Descendant</option>
              </select>
            </div>
            <nav id="customers-top-nav" class="flex flex-row">
              <Link
                  :href="newCustomer()"
                  class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
              >
                  Add a customer
              </Link>
            </nav>
        </section>

        <CustomersList
          classname=""
          :customers=props.customers
          :sort-by="sortBy"
          :order="order"
        />
      </div>
    </AppLayout>
</template>