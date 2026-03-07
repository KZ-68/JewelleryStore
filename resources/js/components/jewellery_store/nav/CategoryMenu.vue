<script setup lang="ts">
import { Category } from '@/types/category';
import { ref } from 'vue';
import { route } from '../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../ziggy.js';
import SubCategory from './SubCategory.vue';

interface CategoryMenuProps {
    frontCategories: Category[]
}

const props = defineProps<CategoryMenuProps>();

const categories = ref<Category[]>(props.frontCategories)
const openCategories = ref(new Set<number>())

function openCategory(id: number) {
  openCategories.value.add(id)
}
function closeCategory(id: number) {
  openCategories.value.delete(id)
}
</script>

<template>
  <nav class="text-lg lg:w-[64rem] bg-white">
    <ul class="flex flex-col lg:flex-row items-center lg:items-start">
      <li 
        v-for="category in categories"
        :key="category.id"
        class="relative group"
      >
        <div 
          v-if="category.name != 'home'"
          class="flex justify-between px-4 py-3 hover:bg-gray-50 transition-colors"
          @mouseenter="openCategory(category.id)" 
          @click="closeCategory(category.id)"
          @touchstart="openCategory(category.id)"
        >
          <a :href="route('showCategoryProducts', {category_slug: category.slug}, false, Ziggy)" class="flex-1 font-medium text-gray-800 hover:text-blue-500 transition-colors"
          >
            {{ category.name }}
          </a>

          <svg
              class="w-5 h-5 transition-transform duration-300"
              :class="{ 'rotate-270': openCategories.has(category.id) }"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" fill="none"/>
          </svg>
        </div>
        <ul v-if="openCategories.has(category.id) && category.children_recursive?.length" class="absolute left-0 top-full flex-col bg-white border shadow-md min-w-[200px] group-hover:flex">
          <SubCategory v-for="subCat in category.children_recursive"
            :key="subCat.id"
            :category="subCat"
            :open-categories="openCategories"
            @open="openCategory"
            @close="closeCategory"
          />
        </ul>
      </li>
    </ul>
  </nav>
</template>