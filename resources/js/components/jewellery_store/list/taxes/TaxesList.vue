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
    <section id="taxes-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <table class="flex flex-col gap-4">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Name</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Rate</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Applicable</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Edit</th>
                </tr>
            </thead>
            <tbody v-if="props.taxes.length > 0" id="taxes-list">
                <tr v-for="tax in props.taxes" v-bind:key="tax.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ tax.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ tax.name }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ tax.rate }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ tax.applicable }}</td>
                    <td class="flex flex-row justify-center m-[1rem 2rem 1rem 2rem] w-[15%] text-center"><Link :href="route('tax-details', {locale: props.locale, slug: tax.slug}, false, Ziggy)"><FileEditIcon/></Link></td>
                </tr>
            </tbody>
            <tbody v-else id="taxes-list">
                <tr>
                    <th scope="row" class="py-2 px-3 h-[5rem]">No Tax registered</th>
                </tr>
            </tbody>
        </table>
    </section>
</template>