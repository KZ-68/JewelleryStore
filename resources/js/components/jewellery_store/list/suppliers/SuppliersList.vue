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
    <section id="suppliers-list-wrapper" class="rounded-lg py-4 px-4 sm:px-8">
        <ul v-if="suppliers.length > 0" id="suppliers-list" class="flex flex-col gap-4">
            <li v-for="supplier in suppliers" v-bind:key="supplier.id" class="bg-white border border-gray-200 rounded-md py-4 px-5 my-3 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">{{ supplier.name }}</li>
        </ul>
        <ul v-else id="suppliers-list" class="flex flex-col gap-4">
            <li class="flex items-center justify-center text-center bg-white border border-gray-200 rounded-md py-4 px-5 my-3 min-h-[5rem] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                <p>No Supplier registered</p>
            </li>
        </ul>
    </section>
</template>