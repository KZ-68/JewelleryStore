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
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const selected = ref<string[]>([]);

const deleteSubCategory = (name: string) => {
    router.post(route('delete-category', {slug: name}, false, Ziggy), {name: name})
}

const getSelected = () => {
    return selected.value
}

defineProps<SubCategoriesListProps>()
defineExpose({
    getSelected
});
</script>

<template>
    <section id="sub-categories-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-8">
        <ul v-if="subCategories.length > 0" id="categories-list" class="flex flex-col gap-4">
            <li v-for="subCategory in subCategories" v-bind:key="subCategory.id" class="flex flex-row justify-between bg-white rounded-md py-4 px-5 my-3">
                <input
                    id="delete"
                    type="checkbox" 
                    name="delete"
                    :value="subCategory.name"
                    v-model="selected"
                    :tabindex="1"
                />
                <p>{{ subCategory.name }}</p>
                <Button @click="deleteSubCategory(subCategory.name)">Delete</Button>
            </li>
        </ul>
        <ul v-else id="sub-categories-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No Category registered</p>
            </li>
        </ul>
    </section>
</template>