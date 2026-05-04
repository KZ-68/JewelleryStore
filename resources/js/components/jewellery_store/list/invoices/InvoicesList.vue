<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import type { Invoice } from '@/types/invoice'
import { FileTextIcon } from 'lucide-vue-next';
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';

interface InvoicesListProps {
    classname:string
    invoices: Invoice[]
    locale: string
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<InvoicesListProps>()

const displayPdf = (number: string) => {
    window.open(route('invoices.displayPdf', {locale: props.locale, number: number}, false, Ziggy), '_blank')
}
</script>

<template>
    <section id="invoices-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[480px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[25%] text-center">Number</th>
                        <th scope="col" class="w-[30%] text-center">Created At</th>
                        <th scope="col" class="w-[15%] text-center">PDF</th>
                    </tr>
                </thead>
                <tbody v-if="invoices.length > 0" id="invoices-list">
                    <tr v-for="invoice in invoices" v-bind:key="invoice.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto">
                        <th scope="row" class="w-[15%] text-center">{{ invoice.id }}</th>
                        <td class="w-[25%] text-center break-words">{{ invoice.number }}</td>
                        <td class="w-[30%] text-center">{{ invoice.created_at }}</td>
                        <td class="w-[15%] flex flex-row justify-center"><Button @click="displayPdf(invoice.number)"><FileTextIcon/></Button></td>
                    </tr>
                </tbody>
                <tbody v-else id="invoices-list">
                    <tr>
                        <th scope="row">No Invoice listed here</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>