<script setup lang="ts">
import type { Manufacturer } from '@/types/manufacturer'
import { router } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue';
import { ref } from "vue";
import { route } from '../../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../../ziggy.js';

interface ManufacturersListProps {
    classname:string
    manufacturers: Manufacturer[]
    sortBy: string
    order: 'asc' | 'desc'
    locale: string
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const selected = ref<string[]>([]);

const deleteManufacturer = (name: string) => {
    router.post(route('delete-manufacturer', {locale: props.locale, slug: name}, false, Ziggy), {name: name})
}

const getSelected = () => {
    return selected.value
}

defineProps<ManufacturersListProps>()
defineExpose({
    getSelected
});
</script>

<template>
    <section id="manufacturers-list-wrapper" class="rounded-lg py-4 px-4 sm:px-8">
        <ul v-if="manufacturers.length > 0" id="manufacturers-list" class="flex flex-col gap-4">
            <li v-for="manufacturer in manufacturers" v-bind:key="manufacturer.id" class="flex flex-row items-center gap-3 justify-between bg-white border border-gray-200 rounded-md py-4 px-4 sm:px-5 my-3 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                <input
                    id="delete"
                    type="checkbox"
                    name="delete"
                    :value="manufacturer.name"
                    v-model="selected"
                    :tabindex="1"
                    class="shrink-0"
                />
                <p class="flex-1 min-w-0 break-words">{{ manufacturer.name }}</p>
                <Button class="shrink-0" @click="deleteManufacturer(manufacturer.name)">Delete</Button>
            </li>
        </ul>
        <ul v-else id="manufacturers-list" class="flex flex-col gap-4">
            <li class="flex items-center justify-center text-center bg-white border border-gray-200 rounded-md py-4 px-5 my-3 min-h-[5rem] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                <p>No Manufacturer registered</p>
            </li>
        </ul>
    </section>
</template>