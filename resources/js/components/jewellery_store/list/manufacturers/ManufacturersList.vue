<script setup lang="ts">
import type { Manufacturer } from '@/types/manufacturer'


const props = defineProps<{
    manufacturers: Manufacturer[]
    sortBy: string
    order: 'asc' | 'desc'
}>()

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

</script>

<template>
    <section id="manufacturers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <h2 class="text-3xl my-6">Manufacturers</h2>
        <ul v-if="props.manufacturers.length > 0" id="manufacturers-list" class="flex flex-col gap-4">
            <li v-for="manufacturer in props.manufacturers" v-bind:key="manufacturer.id" class="bg-white rounded-md py-8 px-5 my-3">{{ manufacturer.name }}</li>
        </ul>
        <ul v-else id="manufacturers-list" class="flex flex-col gap-4">
            <li class="bg-white rounded-md py-8 px-5 my-3">
                <p>No Manufacturer registered</p>
            </li>
        </ul>
    </section>
</template>