<script setup lang="ts">
import type { TaxRuleGroup } from '@/types/taxRuleGroup';
import { Link } from '@inertiajs/vue3'
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';
import { FileEditIcon } from 'lucide-vue-next';

interface TaxRuleGroupsListProps {
    classname:string
    taxRuleGroups: TaxRuleGroup[]    
    sortBy: string
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<TaxRuleGroupsListProps>()
</script>

<template>
    <section id="tax-rule-groups-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
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
            <tbody v-if="taxRuleGroups.length > 0" id="tax-rule-groups-list">
                <tr v-for="taxRuleGroup in taxRuleGroups" v-bind:key="taxRuleGroup.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ taxRuleGroup.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center"><Link :href="route('admin.back-office.taxes.showRuleGroup', {slug: taxRuleGroup.slug}, false, Ziggy)"><FileEditIcon/></Link></td>
                </tr>
            </tbody>
            <tbody v-else id="tax-rule-groups-list">
                <tr>
                    <th scope="row" class="py-2 px-3 h-[5rem]">No Tax Rules registered</th>
                </tr>
            </tbody>
        </table>
    </section>
</template>