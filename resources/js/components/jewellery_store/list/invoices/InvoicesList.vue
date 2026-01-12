<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import type { Invoice } from '@/types/invoice'
import { FileTextIcon } from 'lucide-vue-next';
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { router } from '@inertiajs/vue3'
import { Ziggy } from '../../../../ziggy.js';

interface InvoicesListProps {
    classname:string
    invoices: Invoice[]
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const displayPdf = (number: string) => {
    router.post(route('invoices.displayPdf', {number: number}, false, Ziggy), {number: number})
}

defineProps<InvoicesListProps>()
</script>

<template>
    <section id="invoices-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12 w-4xl">
        <table class="flex flex-col gap-4">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[80%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[80%] text-center">Number</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[80%] text-center">Created At</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[80%] text-center">PDF</th>
                </tr>
            </thead>
            <tbody v-if="invoices.length > 0" id="invoices-list">
                <tr v-for="invoice in invoices" v-bind:key="invoice.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[80%] text-center">{{ invoice.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[80%] text-center">{{ invoice.number }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[80%] text-center">{{ invoice.created_at }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[80%] flex flex-row justify-center"><Button @click="displayPdf(invoice.number)"><FileTextIcon/></Button></td>
                </tr>
            </tbody>
            <tbody v-else id="invoices-list">
                <th scope="row">No Invoice listed here</th>
            </tbody>
        </table>
    </section>
</template>