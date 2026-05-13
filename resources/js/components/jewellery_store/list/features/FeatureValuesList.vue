<script setup lang="ts">
import type { FeatureValue } from '@/types/feature_value'

interface FeatureValuesListProps {
    feature_values: FeatureValue[]
}

defineProps<FeatureValuesListProps>()
</script>

<template>
    <section id="feature_values-list-wrapper" class="rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[280px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[15%] text-center">Value</th>
                    </tr>
                </thead>
                <tbody v-if="feature_values.length > 0" id="feature_values-list">
                    <tr v-for="feature_value in feature_values" v-bind:key="feature_value.id" class="flex flex-row gap-[5%] items-center justify-around bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        <th scope="row" class="w-[15%] text-center">{{ feature_value.id }}</th>
                        <td class="w-[15%] text-center break-words">{{ feature_value.value }}</td>
                    </tr>
                </tbody>
                <tbody v-else id="feature_values-list">
                    <tr class="flex flex-row items-center justify-center bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="text-center font-normal text-gray-500 dark:text-gray-400">No Feature Value registered</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>