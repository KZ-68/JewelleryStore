<script setup lang="ts">
import type { Category } from '@/types/category'
import { router } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue';
import { ref } from "vue";
import { route } from '../../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../../ziggy.js';

interface SubCategoriesListProps {
    classname:string
    subCategories: Category[]
    parentCategoryName: string
    locale: string
}

const props = defineProps<SubCategoriesListProps>()

const selected = ref<string[]>([]);

const deleteSubCategory = (name: string) => {
    router.post(route('delete-category', {locale: props.locale, slug: name}, false, Ziggy), {locale: props.locale, name: name})
}

const getSelected = () => {
    return selected.value
}

defineExpose({
    getSelected
});
</script>

<template>
    <h2 class="text-3xl my-6">Sub Categories for {{ props.parentCategoryName }}</h2>
    <section id="sub-categories-list-wrapper" class="rounded-lg py-4 px-4 sm:px-8">
        <ul v-if="subCategories.length > 0" id="categories-list" class="flex flex-col gap-4">
            <li v-for="subCategory in subCategories" v-bind:key="subCategory.id" class="flex flex-row items-center gap-3 justify-between bg-white border border-gray-200 rounded-md py-4 px-4 sm:px-5 my-3 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                <input
                    id="delete"
                    type="checkbox"
                    name="delete"
                    :value="subCategory.name"
                    v-model="selected"
                    :tabindex="1"
                    class="shrink-0"
                />
                <p class="flex-1 min-w-0 break-words">{{ subCategory.name }}</p>
                <Button class="shrink-0" @click="deleteSubCategory(subCategory.name)">Delete</Button>
            </li>
        </ul>
        <ul v-else id="sub-categories-list" class="flex flex-col gap-4">
            <li class="flex items-center justify-center text-center bg-white border border-gray-200 rounded-md py-4 px-5 my-3 min-h-[5rem] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                <p>No SubCategory registered</p>
            </li>
        </ul>
    </section>
</template>