<script setup lang="ts">
import { ref } from 'vue';
import { Category } from '@/types/category';
import MobileCategoryItem from './MobileCategoryItem.vue';

interface Props {
    locale: string
    frontCategories: Category[]
}

const props = defineProps<Props>();

const openIds = ref<number[]>([])

function toggle(id: number) {
    const idx = openIds.value.indexOf(id)
    if (idx === -1) {
        openIds.value = [...openIds.value, id]
    } else {
        openIds.value = openIds.value.filter(i => i !== id)
    }
}
</script>

<template>
    <nav aria-label="Catégories" class="w-full">
        <ul role="list" class="flex flex-col w-full">
            <MobileCategoryItem
                v-for="category in frontCategories.filter(c => c.name !== 'home')"
                :key="category.id"
                :category="category"
                :locale="locale"
                :open-ids="openIds"
                @toggle="toggle"
            />
        </ul>
    </nav>
</template>
