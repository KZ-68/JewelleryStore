<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link} from '@inertiajs/vue3';
import type { Tax } from '@/types/tax'
import type { TaxRuleGroup } from '@/types/taxRuleGroup'
import TaxesList from '@/components/jewellery_store/list/taxes/TaxesList.vue'
import TaxRuleGroupsList from '@/components/jewellery_store/list/taxes/TaxRuleGroupsList.vue'
import { newTax } from '@/actions/App/Http/Controllers/Admin/TaxFrontController';
import { newTaxRuleGroup } from '@/actions/App/Http/Controllers/Admin/TaxRuleGroupFrontController';
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import Button from '@/components/ui/button/Button.vue';

interface TaxesProps {
  taxes: Tax[]
  taxRuleGroups: TaxRuleGroup[]
  filters: {
    sortBy: string
    order: string
  }
  locale: string
}  

const props = defineProps<TaxesProps>()
  
const sortBy = ref<string>(props.filters.sortBy || 'name')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'asc')

const url = route('admin.back-office.showTaxes', {locale: props.locale}, false, Ziggy);

const updateFilters = () => {
  router.get(url, {
    sortBy: sortBy.value,
    order: order.value,
  });
}

const navigate = (url: string) => {
  router.visit(url, { preserveScroll: true, preserveState: true })
}

const activetab = ref(1);
</script>

<template>
    <Head title="Taxes and Tax" />
    <AppLayout :locale="props.locale">
      <div id="taxes-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Taxes</h2>
        <div class="tabs">
          <div class="tab-header">
            <Button @click="activetab=1" :v-bind:class="[ activetab === 1 ? 'active' : '' ]">Tax</Button>
            <Button @click="activetab=2" :v-bind:class="[ activetab === 2 ? 'active' : '' ]">Tax Rules</Button>
          </div>
          
          <div class="tab-content">
            <div v-if="activetab === 1" class="tabcontent">
              <section id="taxes-top-wrapper" class="flex flex-row justify-between items-center">
                <div id="taxes-filters-wrapper" class="flex flex-row my-6 gap-4">
                  <label for="sortBy" class="my-4">Sort by :</label>
                  <select id="sortBy" v-model="sortBy" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
                    <option value="id">ID</option>
                    <option value="name">Name</option>
                  </select>
                  <label for="order" class="my-4">Order by :</label>
                  <select id="order" v-model="order" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
                    <option value="asc">Ascendant</option>
                    <option value="desc">Descendant</option>
                  </select>
                </div>
                <nav id="taxes-top-nav" class="flex flex-row">
                  <Link
                      :href="newTax({locale: props.locale})"
                      class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                  >
                      Add a tax
                  </Link>
                </nav>
              </section>
                <TaxesList
                  classname=""
                  :taxes=props.taxes
                  :sort-by="sortBy"
                  :order="order"
                  :locale="props.locale"
                />
            </div>
            <div v-else-if="activetab === 2" class="tabcontent">
              <section id="taxes-top-wrapper" class="flex flex-row justify-between items-center">
                <div id="taxes-filters-wrapper" class="flex flex-row my-6 gap-4">
                  <label for="sortBy" class="my-4">Sort by :</label>
                  <select id="sortBy" v-model="sortBy" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
                    <option value="id">ID</option>
                    <option value="name">Name</option>
                  </select>
                  <label for="order" class="my-4">Order by :</label>
                  <select id="order" v-model="order" @change="updateFilters" class="rounded-md bg-neutral-100 p-2">
                    <option value="asc">Ascendant</option>
                    <option value="desc">Descendant</option>
                  </select>
                </div>
                <nav id="taxes-top-nav" class="flex flex-row">
                  <Link
                      :href="newTaxRuleGroup({locale: props.locale})"
                      class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                  >
                      Create a new tax rule
                  </Link>
                </nav>
              </section>
                <TaxRuleGroupsList
                  classname=""
                  :taxRuleGroups=props.taxRuleGroups
                  :sort-by="sortBy"
                  :order="order"
                  :locale="props.locale"
                />
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
</template>