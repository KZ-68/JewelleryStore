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
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const selected = ref<string[]>([]);

const deleteCategory = (name: string) => {
    router.post(route('delete-category', {slug: name}, false, Ziggy), {name: name})
}

const getSelected = () => {
    return selected.value
}

defineProps<CategoriesListProps>()
defineExpose({
    getSelected
});
</script>

<template>
    <section id="categories-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-8">
        <ul v-if="categories.length > 0" id="categories-list" class="flex flex-col gap-4">
            <li v-for="category in categories" v-bind:key="category.id" class="flex flex-row justify-between bg-white rounded-md py-4 px-5 my-3">
                <input
                    id="delete"
                    type="checkbox" 
                    name="delete"
                    :value="category.name"
                    v-model="selected"
                    :tabindex="1"
                />
                <Link :href="route('admin.back-office.showSubCategories', {id: category.id}, false, Ziggy)">{{ category.name }}</Link>
                <Button @click="deleteCategory(category.name)">Delete</Button>
            </li>
        </ul>
        <ul v-else id="categories-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No Category registered</p>
            </li>
        </ul>
    </section>
</template>