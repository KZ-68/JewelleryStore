<script setup lang="ts">
import { Category } from '@/types/category';
import { route } from '../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../ziggy.js';

interface SubCategoryMenuProps {
    category: Category
    openCategories: Set<number>
}

const props = defineProps<SubCategoryMenuProps>();

const emit = defineEmits<{
  (e: 'open', id: number): void
  (e: 'close', id: number): void
}>()
</script>

<template>
    <li @mouseenter="emit('open', props.category.id)" @touchstart="emit('open', props.category.id)" @click="emit('close', props.category.id)" class="relative group/item border-b-2 border-b-gray-100 hover:bg-gray-50 min-h-fitt min-w-[200px]">
        <div class="flex items-center justify-between px-4 py-3 transition-colors">
            <a :href="route('showCategoryProducts', {category_slug: props.category.slug, name: props.category.name}, false, Ziggy)" class="flex-1 font-medium text-gray-800 hover:text-[#84070F] **:transition-colors">
                {{ props.category.name }}
            </a>
            <svg
                class="w-5 h-5 transition-transform duration-300 hover:text-[#84070F] lg:ml-6"
                viewBox="0 0 20 20"
                :class="{ 'rotate-270': openCategories.has(category.id) }"
                fill="currentColor"
                >
                <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" fill="none"/>
            </svg>
        </div>
        <ul v-if="props.openCategories.has(category.id) && props.category.children_recursive?.length" class="absolute top-0 left-full z-10 flex-col bg-white border shadow-md h-fit min-w-[200px] group-hover:flex">
            <SubCategory
                v-for="child in props.category.children_recursive"
                :key="child.id"
                :category="child"
                :open-categories="props.openCategories"
                @open="$emit('open', $event)"
                @close="$emit('close', $event)"
            />
        </ul>
    </li>
</template>