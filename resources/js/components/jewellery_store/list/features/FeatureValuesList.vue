<script setup lang="ts">
import type { FeatureValue } from '@/types/feature_value'

interface FeatureValuesListProps {
    feature_values: FeatureValue[]
}

defineProps<FeatureValuesListProps>()
</script>

<template>
    <section id="feature_values-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[280px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[15%] text-center">Value</th>
                    </tr>
                </thead>
                <tbody v-if="feature_values.length > 0" id="feature_values-list">
                    <tr v-for="feature_value in feature_values" v-bind:key="feature_value.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto">
                        <th scope="row" class="w-[15%] text-center">{{ feature_value.id }}</th>
                        <td class="w-[15%] text-center break-words">{{ feature_value.value }}</td>
                    </tr>
                </tbody>
                <tbody v-else id="feature_values-list">
                    <tr>
                        <th scope="row">No Feature Value registered</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>