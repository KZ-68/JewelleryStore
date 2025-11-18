<script setup lang="ts">
import axios from 'axios';
import type { Manufacturer } from '@/types/manufacturer'
import ManufacturerFrontController from '@/actions/App/Http/Controllers/Admin/ManufacturerFrontController';
import Button from '@/components/ui/button/Button.vue';

interface ManufacturersListProps {
    classname:string
    manufacturers: Manufacturer[]
    sortBy: string
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const deleteManufacturer = (name: string) => {
    axios.post('manufacturers/delete', name)
        .then((res) => {
        console.log(res)
    })
}

defineProps<ManufacturersListProps>()
</script>

<template>
    <section id="manufacturers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-8">
        <ul v-if="manufacturers.length > 0" id="manufacturers-list" class="flex flex-col gap-4">
            <li v-for="manufacturer in manufacturers" v-bind:key="manufacturer.id" class="bg-white rounded-md py-4 px-5 my-3">
                {{ manufacturer.name }}
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