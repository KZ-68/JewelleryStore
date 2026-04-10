<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Category } from '@/types/category';
import CategoriesList from '@/components/jewellery_store/list/categories/CategoriesList.vue';
import SubCategoriesList from '@/components/jewellery_store/list/categories/SubCategoriesList.vue';
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';
import { newCategory } from '@/actions/App/Http/Controllers/Admin/CategoryFrontController';

interface CategoriesProps {
  categories?: Category[]
  subCategories?: Category[]
  parentCategoryName?: string
  locale: string
}

const props = defineProps<CategoriesProps>()

const url = route('admin.back-office.showCategories', {locale: props.locale}, false, Ziggy);
</script>

<template>
    <Head title="Categories" />
    <AppLayout :locale="props.locale">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-950">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <!-- En-tête -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Categories
                        </h1>
                        <p v-if="props.parentCategoryName" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Sub-categories of <span class="font-medium text-gray-700 dark:text-gray-300">{{ props.parentCategoryName }}</span>
                        </p>
                    </div>
                    <Link
                        :href="newCategory({locale: props.locale})"
                        class="inline-flex items-center gap-2 self-start sm:self-auto rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
                    >
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add a category
                    </Link>
                </div>

                <CategoriesList
                    v-if="props.categories"
                    classname=""
                    :categories="props.categories"
                    :locale="props.locale"
                />
                <SubCategoriesList
                    v-else-if="props.subCategories && props.subCategories.length"
                    classname=""
                    :subCategories="props.subCategories"
                    :locale="props.locale"
                    :parentCategoryName="props.parentCategoryName ?? ''"
                />
            </div>
        </div>
    </AppLayout>
</template>
