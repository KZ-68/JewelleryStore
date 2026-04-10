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

interface ManufacturersProps {
  manufacturers: Manufacturer[]
  filters: {
    sortBy: string
    order: string
  }
  locale: string
}

const props = defineProps<ManufacturersProps>()

const sortBy = ref<string>(props.filters.sortBy || 'name')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'asc')

const url = route('admin.back-office.showManufacturers', {locale: props.locale}, false, Ziggy);

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
        router.post(route('delete-manufacturers', {names: names, locale: props.locale}, false, Ziggy), { names: names, locale: props.locale })
    }
}

const navigate = (url: string) => {
  router.visit(url, { preserveScroll: true, preserveState: true })
}
</script>

<template>
    <Head title="Manufacturers" />
    <AppLayout :locale="props.locale">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-950">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <!-- En-tête -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Manufacturers
                    </h1>
                    <div class="flex flex-wrap items-center gap-3 self-start sm:self-auto">
                        <button
                            type="button"
                            @click="deleteSelected"
                            class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition-colors"
                        >
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete selected
                        </button>
                        <Link
                            :href="newManufacturer({locale: props.locale})"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
                        >
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add a manufacturer
                        </Link>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="flex flex-wrap items-center gap-3 mb-6 px-4 py-3 bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 shrink-0">Sort by :</span>
                    <select
                        id="sortBy"
                        v-model="sortBy"
                        @change="updateFilters"
                        aria-label="Sort field"
                        class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                    >
                        <option value="name">Name</option>
                        <option value="created_at">Date created</option>
                    </select>
                    <select
                        id="order"
                        v-model="order"
                        @change="updateFilters"
                        aria-label="Sort order"
                        class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                    >
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>

                <ManufacturersList
                    classname=""
                    :manufacturers="props.manufacturers"
                    :sort-by="sortBy"
                    :order="order"
                    ref="deleteBulkRef"
                    :locale="props.locale"
                />
            </div>
        </div>
    </AppLayout>
</template>
