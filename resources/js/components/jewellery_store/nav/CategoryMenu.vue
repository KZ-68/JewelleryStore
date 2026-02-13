<script setup lang="ts">
import { Category } from '@/types/category';
import { ref } from 'vue';
import { route } from '../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../ziggy.js';

interface CategoryMenuProps {
    frontCategories: Category[]
}

const props = defineProps<CategoryMenuProps>();

const openCategories = ref(new Set());

const toggleCategory = (categoryId : number) => {
  if (openCategories.value.has(categoryId)) {
    openCategories.value.delete(categoryId);
  } else {
    openCategories.value.add(categoryId);
  }
};

const isOpen = (categoryId : number) => {
  return openCategories.value.has(categoryId);
};

const hasChildren = (category: Category) => {
  return category.subCategories && category.subCategories.length > 0;
};
</script>

<template>
  <nav class="text-lg w-[64rem] bg-white">
    <ul class="flex flex-row">
      <li 
        v-for="category in props.frontCategories" 
        :key="category.id"
      >
        <div class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition-colors">
          <a 
            :href="route('showCategoryProducts', {category_slug: category.slug}, false, Ziggy)"
            class="flex-1 font-medium text-gray-800 hover:text-blue-500 transition-colors"
          >
            {{ category.name }}
          </a>
          
          <button
            v-if="hasChildren(category)"
            @click.prevent="toggleCategory(category.id)"
            class="p-1 text-gray-500 hover:text-blue-500 transition-colors"
            :aria-expanded="isOpen(category.id)"
          >
            <svg 
              class="w-5 h-5 transition-transform duration-300"
              :class="{ 'rotate-180': isOpen(category.id) }"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" fill="none"/>
            </svg>
          </button>
        </div>

        <transition
          enter-active-class="transition-all duration-300 ease-in-out"
          leave-active-class="transition-all duration-300 ease-in-out"
          enter-from-class="max-h-0 opacity-0"
          enter-to-class="max-h-[500px] opacity-100"
          leave-from-class="max-h-[500px] opacity-100"
          leave-to-class="max-h-0 opacity-0"
        >
          <ul 
            v-if="hasChildren(category) && isOpen(category.id)"
            class="bg-gray-50 overflow-hidden"
          >
            <li 
              v-for="subcategory in category.subCategories" 
              :key="subcategory.id"
              class="border-t border-gray-200"
            >
              <a 
                href="#"
                class="block py-3 px-4 pl-8 text-sm text-gray-600 hover:bg-white hover:text-blue-500 hover:pl-9 transition-all"
              >
                {{ subcategory.name }}
              </a>
            </li>
          </ul>
        </transition>
      </li>
    </ul>
  </nav>
</template>