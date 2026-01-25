<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { Country } from '@/types/country'

interface ShippingRateTableProps {
    classname:string;
    countries: Country[]
    form: {
        min_total: number
        max_total: number
        price: number
    }
}   

const props = defineProps<ShippingRateTableProps>();
</script>

<template>
    <div id="shipping-rates-table-wrapper">
        <table class="flex flex-col gap-6 w-fit h-fit">
            <thead class="px-2 py-2 w-100 bg-gray-500 text-white">
                <tr>
                    <th>
                        <Label for="min_total">Total price is superior or equal to :</Label>
                    </th>
                    <th v-for="(country, i) in countries"
                    :key="`${country}${i}`"
                    >
                        <Input 
                            :v-model="props.form.min_total"
                            id="min_total"
                            name="min_total"
                            type="number"
                            class="ml-12 mt-1 block w-24 bg-white text-black"
                        />
                    </th>
                </tr>
                <tr>
                    <th>
                        <Label for="max_total">Total price is inferior to :</Label>    
                    </th>
                    <th v-for="(country, i) in countries"
                    :key="`${country}${i}`"
                    >
                        <Input 
                            :v-model="props.form.max_total"
                            id="max_total"
                            name="max_total"
                            type="number"
                            class="ml-12 mt-1 block w-24 bg-white text-black"
                        />
                    </th>
                </tr>
            </thead>
            <tbody class="w-100">
                <tr
                    v-for="country in countries"
                    :key="`entity-${country.name}`"
                    class="flex flex-row w-100 justify-between content-center border-1 border-slate-300 round-lg"
                >
                    <th class="mx-8 my-8">
                        {{ country.name }}
                    </th>
                    <td v-for="(country, i) in countries"
                    :key="`${country}${i}`">
                        <Input 
                            :v-model="props.form.price"
                            id="price"
                            name="price"
                            type="number"
                            class="mx-8 my-8 block w-24"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>