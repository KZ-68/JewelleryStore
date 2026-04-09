<script setup lang="ts">
import { Category } from '@/types/category';
import { route } from '../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../ziggy.js';

interface SubCategoryMenuProps {
    locale: string
    category: Category
    openCategories: Set<number>
}

const props = defineProps<SubCategoryMenuProps>();

const emit = defineEmits<{
    (e: 'open', id: number): void
    (e: 'close', id: number): void
}>()

function toggle() {
    props.openCategories.has(props.category.id)
        ? emit('close', props.category.id)
        : emit('open', props.category.id)
}
</script>

<template>
    <li
        class="relative border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors min-w-[200px]"
        @mouseenter="emit('open', props.category.id)"
        @mouseleave="emit('close', props.category.id)"
    >
        <div class="flex items-center px-4 py-2.5">
            <a
                :href="route('showCategoryProducts', {locale: props.locale, category_slug: props.category.slug, name: props.category.name}, false, Ziggy)"
                class="flex-1 text-sm font-medium text-gray-800 hover:text-[#84070F] transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] rounded-sm"
            >
                {{ props.category.name }}
            </a>

            <button
                v-if="props.category.children_recursive?.length"
                @click="toggle"
                :aria-expanded="props.openCategories.has(props.category.id).toString()"
                :aria-label="`Sous-catégories de ${props.category.name}`"
                class="ml-4 p-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#84070F] transition-colors cursor-pointer"
            >
                <svg
                    aria-hidden="true"
                    class="w-4 h-4 text-gray-400 transition-transform duration-200"
                    :class="{ 'rotate-90': props.openCategories.has(props.category.id) }"
                    viewBox="0 0 20 20"
                    fill="none"
                >
                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <ul
            v-if="props.openCategories.has(props.category.id) && props.category.children_recursive?.length"
            role="list"
            class="absolute top-0 left-full z-20 flex flex-col bg-white border border-gray-100 shadow-lg rounded-md overflow-hidden min-w-[200px]"
        >
            <SubCategory
                v-for="child in props.category.children_recursive"
                :locale="props.locale"
                :key="child.id"
                :category="child"
                :open-categories="props.openCategories"
                @open="$emit('open', $event)"
                @close="$emit('close', $event)"
            />
        </ul>
    </li>
</template>
