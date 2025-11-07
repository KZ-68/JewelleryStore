<script setup lang="ts">
import type { Manufacturer } from '@/types/manufacturer'


interface ManufacturersListProps {
    classname:string
    manufacturers: Manufacturer[]
    sortBy: string
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<ManufacturersListProps>()
</script>

<template>
    <section id="manufacturers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <ul v-if="manufacturers.length > 0" id="manufacturers-list" class="flex flex-col gap-4">
            <li v-for="manufacturer in manufacturers" v-bind:key="manufacturer.id" class="bg-white rounded-md py-8 px-5 my-3">{{ manufacturer.name }}</li>
        </ul>
        <ul v-else id="manufacturers-list" class="flex flex-col gap-4">
            <li class="bg-white rounded-md py-8 px-5 my-3">
                <p>No Manufacturer registered</p>
            </li>
        </ul>
    </section>
</template>