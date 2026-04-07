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
    <section id="features-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <table class="flex flex-col gap-4">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Name</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Edit</th>
                </tr>
            </thead>
            <tbody v-if="features.length > 0" id="features-list">
                <tr v-for="feature in features" v-bind:key="feature.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ feature.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ feature.name }}</td>
                    <td class="flex flex-row justify-center m-[1rem 2rem 1rem 2rem] w-[15%] text-center"><Link :href="route('feature-details', {locale: props.locale, slug: feature.slug}, false, Ziggy)"><FileEditIcon/></Link></td>
                </tr>
            </tbody>
            <tbody v-else id="features-list">
                <tr>
                    <th scope="row">No Feature registered</th>
                </tr>
            </tbody>
        </table>
    </section>
</template>