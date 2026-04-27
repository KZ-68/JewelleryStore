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

const activeTab = ref<1 | 2>(1);
</script>

<template>
    <Head title="Taxes" />
    <AppLayout :locale="props.locale">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-950">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <!-- En-tête -->
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">
                    Taxes
                </h1>

                <!-- Onglets -->
                <div role="tablist" aria-label="Tax sections" class="flex gap-1 border-b border-gray-200 dark:border-gray-800 mb-6">
                    <button
                        id="tab-taxes"
                        role="tab"
                        :aria-selected="(activeTab === 1).toString()"
                        aria-controls="panel-taxes"
                        @click="activeTab = 1"
                        :class="activeTab === 1
                            ? 'border-b-2 border-gray-900 text-gray-900 dark:border-white dark:text-white'
                            : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-5 py-3 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-900"
                    >
                        Taxes
                    </button>
                    <button
                        id="tab-rules"
                        role="tab"
                        :aria-selected="(activeTab === 2).toString()"
                        aria-controls="panel-rules"
                        @click="activeTab = 2"
                        :class="activeTab === 2
                            ? 'border-b-2 border-gray-900 text-gray-900 dark:border-white dark:text-white'
                            : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-5 py-3 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-900"
                    >
                        Tax Rules
                    </button>
                </div>

                <!-- Panneau Taxes -->
                <div
                    v-if="activeTab === 1"
                    id="panel-taxes"
                    role="tabpanel"
                    aria-labelledby="tab-taxes"
                >
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div class="flex flex-wrap items-center gap-3 px-4 py-3 bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400 shrink-0">Sort by :</span>
                            <select
                                id="sortBy-taxes"
                                v-model="sortBy"
                                @change="updateFilters"
                                aria-label="Sort field"
                                class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                            >
                                <option value="id">ID</option>
                                <option value="name">Name</option>
                            </select>
                            <select
                                id="order-taxes"
                                v-model="order"
                                @change="updateFilters"
                                aria-label="Sort order"
                                class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                            >
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                        <Link
                            :href="newTax({locale: props.locale})"
                            class="inline-flex items-center gap-2 self-start sm:self-auto rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
                        >
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add a tax
                        </Link>
                    </div>
                    <TaxesList
                        classname=""
                        :taxes="props.taxes"
                        :sort-by="sortBy"
                        :order="order"
                        :locale="props.locale"
                    />
                </div>

                <!-- Panneau Tax Rules -->
                <div
                    v-else-if="activeTab === 2"
                    id="panel-rules"
                    role="tabpanel"
                    aria-labelledby="tab-rules"
                >
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div class="flex flex-wrap items-center gap-3 px-4 py-3 bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400 shrink-0">Sort by :</span>
                            <select
                                id="sortBy-rules"
                                v-model="sortBy"
                                @change="updateFilters"
                                aria-label="Sort field"
                                class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                            >
                                <option value="id">ID</option>
                                <option value="name">Name</option>
                            </select>
                            <select
                                id="order-rules"
                                v-model="order"
                                @change="updateFilters"
                                aria-label="Sort order"
                                class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                            >
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                        <Link
                            :href="newTaxRuleGroup({locale: props.locale})"
                            class="inline-flex items-center gap-2 self-start sm:self-auto rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
                        >
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create a tax rule
                        </Link>
                    </div>
                    <TaxRuleGroupsList
                        classname=""
                        :taxRuleGroups="props.taxRuleGroups"
                        :sort-by="sortBy"
                        :order="order"
                        :locale="props.locale"
                    />
                </div>

            </div>
        </div>
    </AppLayout>
</template>
