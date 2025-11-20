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
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const selected = ref<string[]>([]);

const deleteManufacturer = (name: string) => {
    router.post(route('delete-manufacturer', {slug: name}, false, Ziggy), {name: name})
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
    <section id="manufacturers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-8">
        <ul v-if="manufacturers.length > 0" id="manufacturers-list" class="flex flex-col gap-4">
            <li v-for="manufacturer in manufacturers" v-bind:key="manufacturer.id" class="flex flex-row justify-between bg-white rounded-md py-4 px-5 my-3">
                <input
                    id="delete"
                    type="checkbox" 
                    name="delete"
                    :value="manufacturer.name"
                    v-model="selected"
                    :tabindex="1"
                />
                <p>{{ manufacturer.name }}</p>
                <Button @click="deleteManufacturer(manufacturer.name)">Delete</Button>
            </li>
        </ul>
        <ul v-else id="manufacturers-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No Manufacturer registered</p>
            </li>
        </ul>
    </section>
</template>