<script setup lang="ts">
import type { Carrier } from '@/types/carrier'
import { router } from '@inertiajs/vue3'
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';

interface CarriersListProps {
    classname:string
    carriers: Carrier[]
}

const selectCarrier = (id: number) => {
    router.post(route('order.selectCarrier', {carrierId: id}, false, Ziggy), {carrierId: id})
}

defineProps<CarriersListProps>()
</script>

<template>
    <section id="carriers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-8">
        <ul v-if="carriers.length > 0" id="carriers-list" class="flex flex-col gap-4">
            <li @click="selectCarrier(carrier.id)" v-for="carrier in carriers" v-bind:key="carrier.id" class="flex flex-row justify-between bg-white rounded-md py-4 px-5 my-3">
                <figure>
                    <img :src="`/storage/img/icons/carriers/${carrier.name}_small`" alt="Carrier Icon">
                </figure>
                <p>{{ carrier.name }}</p>
            </li>
        </ul>
        <ul v-else id="carriers-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No Carrier available</p>
            </li>
        </ul>
    </section>
</template>