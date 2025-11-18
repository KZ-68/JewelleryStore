<script setup lang="ts">
import type { Supplier } from '@/types/supplier'


interface SuppliersListProps {
    classname:string
    suppliers: Supplier[]
    sortBy: string
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<SuppliersListProps>()
</script>

<template>
    <section id="suppliers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-8">
        <ul v-if="suppliers.length > 0" id="suppliers-list" class="flex flex-col gap-4">
            <li v-for="supplier in suppliers" v-bind:key="supplier.id" class="bg-white rounded-md py-4 px-5 my-3">{{ supplier.name }}</li>
        </ul>
        <ul v-else id="suppliers-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No Supplier registered</p>
            </li>
        </ul>
    </section>
</template>