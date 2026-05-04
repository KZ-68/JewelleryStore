<script setup lang="ts">
import type { Customer } from '@/types/customer'

interface CustomersListProps {
    classname:string
    customers: Customer[]
    sortBy: string
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<CustomersListProps>()
</script>

<template>
    <section id="customers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[480px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[15%] text-center">Name</th>
                        <th scope="col" class="w-[15%] text-center">Email</th>
                        <th scope="col" class="w-[15%] text-center">Created At</th>
                    </tr>
                </thead>
                <tbody v-if="customers.length > 0" id="customers-list">
                    <tr v-for="customer in customers" v-bind:key="customer.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto">
                        <th scope="row" class="w-[15%] text-center">{{ customer.id }}</th>
                        <td class="w-[15%] text-center break-words">{{ customer.name }}</td>
                        <td class="w-[15%] text-center break-all">{{ customer.email }}</td>
                        <td class="w-[15%] text-center">{{ customer.created_at }}</td>
                    </tr>
                </tbody>
                <tbody v-else id="customers-list">
                    <tr>
                        <th scope="row">No Customer registered</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>