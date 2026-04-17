<script setup lang="ts">
import type { Order } from '@/types/order'
import { Link } from '@inertiajs/vue3'
import { route } from '../../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../../ziggy.js';
import { FileEditIcon } from 'lucide-vue-next';

interface OrdersListProps {
    classname:string
    orders: Order[]
    filters: {
        sortBy: string
        orderBy: "asc" | "desc"
    }
    locale: string
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<OrdersListProps>()
</script>

<template>
    <section id="orders-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <table class="flex flex-col gap-4">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Reference</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Created At</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Edit</th>
                </tr>
            </thead>
            <tbody v-if="orders.length > 0" id="orders-list">
                <tr v-for="order in orders" v-bind:key="order.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ order.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ order.reference }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ order.created_at }}</td>
                    <td class="flex flex-row justify-center m-[1rem 2rem 1rem 2rem] w-[15%] text-center"><Link :href="route('order-details', {locale: props.locale,slug: order.reference}, false, Ziggy)"><FileEditIcon/></Link></td>
                </tr>
            </tbody>
            <tbody v-else id="orders-list">
                <tr>
                    <th scope="row">No Order registered</th>
                </tr>
            </tbody>
        </table>
    </section>
</template>