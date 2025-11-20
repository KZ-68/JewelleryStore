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
}  

const props = defineProps<CategoriesProps>()

const url = route('admin.back-office.showCategories', {}, false, Ziggy);
</script>

<template>
    <Head title="Categories" />
    <AppLayout>
      <div id="categories-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Categories</h2>
        <section id="categories-top-wrapper" class="flex lg:flex-row sm:flex-col lg:my-0 sm:my-6 justify-between items-center">
            <nav id="categories-top-nav" class="flex flex-row">
              <Link
                  :href="newCategory()"
                  class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
              >
                  Add a category
              </Link>
            </nav>
        </section>

        <CategoriesList
          v-if="props.categories !== undefined"
          classname=""
          :categories=props.categories
        />
        <SubCategoriesList 
          v-else-if="props.subCategories !== undefined"
          classname=""
          :subCategories=props.subCategories
        />
      </div>
    </AppLayout>
</template>