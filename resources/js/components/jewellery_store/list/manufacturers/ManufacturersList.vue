<script setup lang="ts">
import type { Manufacturer } from '@/types/manufacturer'

interface ManufacturersListProps {
    classname:string;
    manufacturers: Manufacturer[]
}    

defineProps<ManufacturersListProps>();
</script>

<template>
    <section id="manufacturers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <h2 class="text-3xl my-6">Manufacturers</h2>
        <ul id="manufacturers-list" class="flex flex-col gap-4">
            <li v-for="manufacturer in manufacturers" class="bg-white rounded-md py-8 px-5 my-3">{{ manufacturer.name }}</li>
        </ul>
    </section>
</template>