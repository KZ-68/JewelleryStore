<script setup lang="ts">
import type { Feature } from '@/types/feature'
import { Link } from '@inertiajs/vue3'
import { route } from '../../../../../../vendor/tightenco/ziggy'
import { Ziggy } from '../../../../ziggy.js'
import { FileEditIcon } from 'lucide-vue-next'

interface FeaturesListProps {
    features: Feature[]
    sortBy: string
    order: "asc" | "desc"
    locale: string
}

const props = defineProps<FeaturesListProps>()
</script>

<template>
    <section id="features-list-wrapper" class="rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[360px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[15%] text-center">Name</th>
                        <th scope="col" class="w-[15%] text-center">Edit</th>
                    </tr>
                </thead>
                <tbody v-if="features.length > 0" id="features-list">
                    <tr v-for="feature in features" v-bind:key="feature.id" class="flex flex-row gap-[5%] items-center justify-around bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        <th scope="row" class="w-[15%] text-center">{{ feature.id }}</th>
                        <td class="w-[15%] text-center break-words">{{ feature.name }}</td>
                        <td class="flex flex-row justify-center w-[15%] text-center"><Link :href="route('feature-details', {locale: props.locale, slug: feature.slug}, false, Ziggy)"><FileEditIcon/></Link></td>
                    </tr>
                </tbody>
                <tbody v-else id="features-list">
                    <tr class="flex flex-row items-center justify-center bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="text-center font-normal text-gray-500 dark:text-gray-400">No Feature registered</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>