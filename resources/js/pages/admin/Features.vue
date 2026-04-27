<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import type { Feature } from '@/types/feature'
import FeaturesList from '@/components/jewellery_store/list/features/FeaturesList.vue'
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';
import { newFeature } from '@/actions/App/Http/Controllers/Admin/FeatureFrontController';

interface FeaturesProps {
  features: Feature[]
  filters: {
    sortBy: string
    order: string
  }
  locale: string
}

const props = defineProps<FeaturesProps>()

const sortBy = ref<string>(props.filters.sortBy || 'id')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'desc')

const url = route('admin.back-office.featuresList', {locale: props.locale}, false, Ziggy);

const updateFeaturesFilters = () => {
  router.get(url, {
    sortBy: sortBy.value,
    order: order.value,
  });
}
</script>

<template>
    <Head title="Features" />
    <AppLayout :locale="props.locale">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-950">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <!-- En-tête -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Features
                    </h1>
                    <Link
                        :href="newFeature({locale: props.locale})"
                        class="inline-flex items-center gap-2 self-start sm:self-auto rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
                    >
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add a feature
                    </Link>
                </div>

                <!-- Filtres -->
                <div class="flex flex-wrap items-center gap-3 mb-6 px-4 py-3 bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 shrink-0">Sort by :</span>
                    <select
                        id="sortBy"
                        v-model="sortBy"
                        @change="updateFeaturesFilters"
                        aria-label="Sort field"
                        class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                    >
                        <option value="id">ID</option>
                        <option value="name">Name</option>
                        <option value="created_at">Date created</option>
                    </select>
                    <select
                        id="order"
                        v-model="order"
                        @change="updateFeaturesFilters"
                        aria-label="Sort order"
                        class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                    >
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>

                <FeaturesList
                    :features="props.features"
                    :sort-by="sortBy"
                    :order="order"
                    :locale="props.locale"
                />
            </div>
        </div>
    </AppLayout>
</template>
