<script setup lang="ts">
import type { Category } from '@/types/category'
import { Link, router } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue';
import { ref } from "vue";
import { route } from '../../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../../ziggy.js';

interface CategoriesListProps {
    classname:string
    categories: Category[]
    locale: string
}

const props = defineProps<CategoriesListProps>()

const selected = ref<string[]>([]);

const deleteCategory = (name: string) => {
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
    <h2 class="text-3xl my-6">Categories</h2>
    <section id="categories-list-wrapper" class="rounded-lg py-4 px-4 sm:px-8">
        <ul v-if="categories.length > 0" id="categories-list" class="flex flex-col gap-4">
            <li v-for="category in categories" v-bind:key="category.id" class="flex flex-row items-center gap-3 justify-between bg-white border border-gray-200 rounded-md py-4 px-4 sm:px-5 my-3 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                <input
                    id="delete"
                    type="checkbox"
                    name="delete"
                    :value="category.name"
                    v-model="selected"
                    :tabindex="1"
                    class="shrink-0"
                />
                <Link class="flex-1 min-w-0 break-words" :href="route('admin.back-office.showSubCategories', {locale: props.locale, id: category.id}, false, Ziggy)">{{ category.name }}</Link>
                <Button class="shrink-0" @click="deleteCategory(category.name)">Delete</Button>
            </li>
        </ul>
        <ul v-else id="categories-list" class="flex flex-col gap-4">
            <li class="flex items-center justify-center text-center bg-white border border-gray-200 rounded-md py-4 px-5 my-3 min-h-[5rem] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                <p>No Category registered</p>
            </li>
        </ul>
    </section>
</template>