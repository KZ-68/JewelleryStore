<script setup lang="ts">
import type { Role } from '@/types/role'


interface RolesListCheckboxProps {
    classname:string
    roles: Role[]
    sortBy: string
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<RolesListCheckboxProps>()
</script>

<template>
    <section id="roles-list-wrapper" class="rounded-lg py-4 px-4 sm:px-8">
        <ul v-if="roles.length > 0" id="roles-list" class="flex flex-col gap-4">
            <li v-for="role in roles" v-bind:key="role.id" class="bg-white border border-gray-200 rounded-md py-4 px-5 my-3 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">{{ role.name }}</li>
        </ul>
        <ul v-else id="roles-list" class="flex flex-col gap-4">
            <li class="flex items-center justify-center text-center bg-white border border-gray-200 rounded-md py-4 px-5 my-3 min-h-[5rem] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                <p>No Role registered</p>
            </li>
        </ul>
    </section>
</template>