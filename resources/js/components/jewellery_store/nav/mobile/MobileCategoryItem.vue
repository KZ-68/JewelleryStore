<script setup lang="ts">
import { Category } from '@/types/category';
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';

interface Props {
    category: Category
    locale: string
    openIds: number[]
    depth?: number
}

const props = withDefaults(defineProps<Props>(), { depth: 0 })

const emit = defineEmits<{
    (e: 'toggle', id: number): void
}>()

const isOpen = () => props.openIds.includes(props.category.id)
const hasChildren = () => !!props.category.children_recursive?.length
</script>

<template>
    <li>
        <!-- Ligne principale : toggle si sous-catégories, lien direct sinon -->
        <div
            class="flex items-center gap-2 py-3 pr-4 border-b border-gray-100 hover:bg-gray-50 transition-colors"
            :style="{ paddingLeft: `${1 + depth * 0.75}rem` }"
        >
            <button
                v-if="hasChildren()"
                @click="emit('toggle', category.id)"
                class="flex-1 text-left font-medium text-gray-800 focus:outline-none"
                :aria-expanded="isOpen().toString()"
            >
                {{ category.name }}
            </button>
            <a
                v-else
                :href="route('showCategoryProducts', { locale, category_slug: category.slug }, false, Ziggy)"
                class="flex-1 font-medium text-gray-800 hover:text-[#84070F] transition-colors"
            >
                {{ category.name }}
            </a>

            <button
                v-if="hasChildren()"
                @click="emit('toggle', category.id)"
                :aria-label="`${isOpen() ? 'Fermer' : 'Ouvrir'} ${category.name}`"
                class="p-1 rounded focus:outline-none focus:ring-2 focus:ring-[#84070F] shrink-0"
            >
                <svg
                    aria-hidden="true"
                    class="w-4 h-4 text-gray-500 transition-transform duration-200"
                    :class="{ 'rotate-180': isOpen() }"
                    viewBox="0 0 20 20" fill="none"
                >
                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- Sous-liste dépliable -->
        <ul v-if="hasChildren() && isOpen()" role="list">
            <!-- Lien "Voir toute la catégorie" en tête de liste -->
            <li>
                <a
                    :href="route('showCategoryProducts', { locale, category_slug: category.slug }, false, Ziggy)"
                    class="flex items-center gap-2 py-2.5 pr-4 border-b border-gray-100 text-sm font-semibold text-[#84070F] hover:bg-red-50 transition-colors"
                    :style="{ paddingLeft: `${1.75 + depth * 0.75}rem` }"
                >
                    <svg aria-hidden="true" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                    Voir tout — {{ category.name }}
                </a>
            </li>

            <!-- Sous-catégories récursives -->
            <MobileCategoryItem
                v-for="child in category.children_recursive"
                :key="child.id"
                :category="child"
                :locale="locale"
                :open-ids="openIds"
                :depth="depth + 1"
                @toggle="emit('toggle', $event)"
            />
        </ul>
    </li>
</template>
