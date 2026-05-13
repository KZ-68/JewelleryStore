<script setup lang="ts">
import type { User } from '@/types/user'

interface UsersListProps {
    classname:string
    users: User[]
    sortBy: string
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<UsersListProps>()
</script>

<template>
    <section id="users-list-wrapper" class="rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[480px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[15%] text-center">Name</th>
                        <th scope="col" class="w-[15%] text-center">Email</th>
                        <th scope="col" class="w-[15%] text-center">Role</th>
                    </tr>
                </thead>
                <tbody v-if="users.length > 0" id="users-list">
                    <tr v-for="user in users" v-bind:key="user.id" class="flex flex-row gap-[5%] items-center justify-around bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        <th scope="row" class="w-[15%] text-center">{{ user.id }}</th>
                        <td class="w-[15%] text-center break-words">{{ user.name }}</td>
                        <td class="w-[15%] text-center break-all">{{ user.email }}</td>
                        <td class="w-[15%] text-center">{{ user.roles?.[0]?.name ?? '-' }}</td>
                    </tr>
                </tbody>
                <tbody v-else id="users-list">
                    <tr class="flex flex-row items-center justify-center bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="text-center font-normal text-gray-500 dark:text-gray-400">No User registered</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>