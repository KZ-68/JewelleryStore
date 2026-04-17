<script setup lang="ts">
import { Category } from '@/types/category';
import { ref } from 'vue';
import { route } from '../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../ziggy.js';
import SubCategory from './SubCategory.vue';

interface CategoryMenuProps {
    locale: string
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

function toggleCategory(id: number) {
    openCategories.value.has(id) ? closeCategory(id) : openCategory(id)
}
</script>

<template>
    <nav aria-label="Catégories" class="bg-white w-full px-4 md:px-6 max-w-screen-2xl mx-auto">
        <ul class="flex flex-col lg:flex-row lg:items-center">
            <li
                v-for="category in categories"
                :key="category.id"
                class="relative"
                @mouseenter="openCategory(category.id)"
                @mouseleave="closeCategory(category.id)"
            >
                <div
                    v-if="category.name !== 'home'"
                    class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors"
                >
                    <a
                        :href="route('showCategoryProducts', {locale: props.locale, category_slug: category.slug}, false, Ziggy)"
                        class="flex-1 font-medium text-sm text-gray-800 hover:text-[#84070F] transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] rounded-sm"
                    >
                        {{ category.name }}
                    </a>

                    <button
                        v-if="category.children_recursive?.length"
                        @click="toggleCategory(category.id)"
                        :aria-expanded="openCategories.has(category.id).toString()"
                        :aria-label="`Sous-catégories de ${category.name}`"
                        class="ml-2 p-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#84070F] transition-colors cursor-pointer"
                    >
                        <svg
                            aria-hidden="true"
                            class="w-4 h-4 text-gray-500 transition-transform duration-200"
                            :class="{ 'rotate-180': openCategories.has(category.id) }"
                            viewBox="0 0 20 20"
                            fill="none"
                        >
                            <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <ul
                    v-if="openCategories.has(category.id) && category.children_recursive?.length"
                    role="list"
                    class="absolute left-0 top-full z-20 flex flex-col bg-white border border-gray-100 shadow-lg rounded-md overflow-hidden min-w-[200px]"
                >
                    <SubCategory
                        v-for="subCat in category.children_recursive"
                        :locale="props.locale"
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
