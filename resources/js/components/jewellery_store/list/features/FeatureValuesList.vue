<script setup lang="ts">
import type { FeatureValue } from '@/types/feature_value'

interface FeatureValuesListProps {
    feature_values: FeatureValue[]
}

defineProps<FeatureValuesListProps>()
</script>

<template>
    <section id="feature_values-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <table class="flex flex-col gap-4">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Value</th>
                </tr>
            </thead>
            <tbody v-if="feature_values.length > 0" id="feature_values-list">
                <tr v-for="feature_value in feature_values" v-bind:key="feature_value.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ feature_value.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ feature_value.value }}</td>
                </tr>
            </tbody>
            <tbody v-else id="feature_values-list">
                <tr>
                    <th scope="row">No Feature Value registered</th>
                </tr>
            </tbody>
        </table>
    </section>
</template>