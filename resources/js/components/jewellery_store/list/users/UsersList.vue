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
    <section id="users-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <table class="flex flex-col gap-4">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Name</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Email</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Role</th>
                </tr>
            </thead>
            <tbody v-if="users.length > 0" id="users-list">
                <tr v-for="user in users" v-bind:key="user.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ user.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ user.name }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ user.email }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ user.roles[0].name }}</td>
                </tr>
            </tbody>
            <tbody v-else id="users-list">
                <th scope="row">No User registered</th>
            </tbody>
        </table>
    </section>
</template>