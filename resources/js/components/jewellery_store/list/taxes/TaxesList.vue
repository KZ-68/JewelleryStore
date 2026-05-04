<script setup lang="ts">
import type { Tax } from '@/types/tax';
import { Link } from '@inertiajs/vue3'
import { route } from '../../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../../ziggy.js';
import { FileEditIcon } from 'lucide-vue-next';

interface TaxesListProps {
    classname:string
    taxes: Tax[]
    sortBy: string
    order: 'asc' | 'desc'
    locale: string
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<TaxesListProps>()
</script>

<template>
    <section id="taxes-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[480px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[15%] text-center">Name</th>
                        <th scope="col" class="w-[15%] text-center">Rate</th>
                        <th scope="col" class="w-[15%] text-center">Applicable</th>
                        <th scope="col" class="w-[15%] text-center">Edit</th>
                    </tr>
                </thead>
                <tbody v-if="props.taxes.length > 0" id="taxes-list">
                    <tr v-for="tax in props.taxes" v-bind:key="tax.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto">
                        <th scope="row" class="w-[15%] text-center">{{ tax.id }}</th>
                        <td class="w-[15%] text-center break-words">{{ tax.name }}</td>
                        <td class="w-[15%] text-center">{{ tax.rate }}</td>
                        <td class="w-[15%] text-center">{{ tax.applicable }}</td>
                        <td class="flex flex-row justify-center w-[15%] text-center"><Link :href="route('tax-details', {locale: props.locale, slug: tax.slug}, false, Ziggy)"><FileEditIcon/></Link></td>
                    </tr>
                </tbody>
                <tbody v-else id="taxes-list">
                    <tr>
                        <th scope="row" class="py-2 px-3">No Tax registered</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>